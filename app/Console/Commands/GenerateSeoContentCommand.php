<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Blog;
use App\Models\ProductHead;
use App\Services\AIChatbotService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GenerateSeoContentCommand extends Command
{
    protected $signature = 'seo:generate-content
                            {--type=products : Target type — "products" or "blogs"}
                            {--limit=0 : Limit number to process (0 = all missing)}
                            {--force : Re-generate even if seo_title/seo_desc already exist}';

    protected $aliases = ['ai:seo-content'];

    protected $description = 'Auto-generate SEO meta titles and descriptions for products/blogs using AI (OpenRouter/Gemini)';

    public function handle(AIChatbotService $chatbotService): int
    {
        $type  = $this->option('type');
        $limit = (int) $this->option('limit');
        $force = (bool) $this->option('force');

        if (!in_array($type, ['products', 'blogs'])) {
            $this->error("Invalid --type. Use 'products' or 'blogs'.");
            return self::FAILURE;
        }

        $apiKey = config('services.openrouter.api_key');
        if (empty($apiKey)) {
            $this->error('❌ No OpenRouter API key found. Set OPENROUTER_API_KEY in .env');
            return self::FAILURE;
        }

        $model = config('services.openrouter.model', 'google/gemini-2.0-flash-exp:free');

        // ── Query records missing SEO content ─────────────────────────────────
        if ($type === 'products') {
            $query = ProductHead::query();
            if (!$force) {
                $query->where(function ($q) {
                    $q->whereNull('seo_title')->orWhere('seo_title', '')->orWhereNull('seo_desc')->orWhere('seo_desc', '');
                });
            }
        } else {
            $query = Blog::query();
            if (!$force) {
                $query->where(function ($q) {
                    $q->whereNull('seo_title')->orWhere('seo_title', '')->orWhereNull('seo_desc')->orWhere('seo_desc', '');
                });
            }
        }

        if ($limit > 0) {
            $query->limit($limit);
        }

        $records = $query->get();
        $total   = $records->count();

        if ($total === 0) {
            $this->info("✅ All {$type} already have SEO content. Use --force to regenerate.");
            return self::SUCCESS;
        }

        $this->info("🤖 Generating SEO content for {$total} {$type}...");
        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $success = 0;
        $failed  = 0;

        foreach ($records as $record) {
            $titleField = $type === 'products' ? $record->title : $record->title;
            $descField  = $type === 'products'
                ? strip_tags((string) $record->short_desc)
                : strip_tags((string) $record->description);

            $categories = '';
            if ($type === 'products' && method_exists($record, 'sub_categories')) {
                $categories = $record->sub_categories()->pluck('title')->implode(', ');
            }

            $prompt = "You are an SEO expert for a Pakistani e-commerce store called 'Everyday Plastic' that sells plastic homeware.\n"
                . "Write an SEO meta title (max 60 characters) and meta description (max 155 characters) for the following {$type} item.\n"
                . "Include the product name and 'Pakistan' or 'Everyday Plastic' naturally.\n"
                . "Title: {$titleField}\n"
                . "Description: " . substr($descField, 0, 300) . "\n"
                . ($categories ? "Categories: {$categories}\n" : '')
                . "Return ONLY valid JSON in this exact format: {\"seo_title\": \"...\", \"seo_desc\": \"...\"}";

            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'HTTP-Referer'  => config('app.url'),
                    'X-Title'       => 'Everyday Shops SEO Generator',
                ])->timeout(15)->post('https://openrouter.ai/api/v1/chat/completions', [
                    'model'      => $model,
                    'messages'   => [
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'max_tokens' => 200,
                ]);

                if ($response->successful()) {
                    $content = trim((string) $response->json('choices.0.message.content'));

                    // Strip markdown code fences if AI wraps JSON in ```json ... ```
                    $content = preg_replace('/^```(?:json)?\s*/i', '', $content);
                    $content = preg_replace('/\s*```$/', '', $content);

                    $parsed = json_decode($content, true);

                    if (isset($parsed['seo_title'], $parsed['seo_desc'])) {
                        $record->update([
                            'seo_title' => substr($parsed['seo_title'], 0, 60),
                            'seo_desc'  => substr($parsed['seo_desc'],  0, 155),
                        ]);
                        $success++;
                    } else {
                        $failed++;
                        $this->newLine();
                        $this->warn("⚠️  Invalid JSON response for: {$titleField}");
                    }
                } else {
                    $failed++;
                }
            } catch (\Throwable $e) {
                $failed++;
                $this->newLine();
                $this->error("❌ Failed [{$titleField}]: " . $e->getMessage());
            }

            $bar->advance();
            usleep(500_000); // 500ms delay to avoid API rate limits
        }

        $bar->finish();
        $this->newLine(2);

        $this->table(
            ['Metric', 'Count'],
            [
                ['Total processed', $total],
                ['✅ Success',       $success],
                ['❌ Failed',        $failed],
            ]
        );

        if ($failed > 0) {
            $this->warn('Re-run to retry failed items (they still have NULL seo_title/seo_desc).');
            return self::FAILURE;
        }

        $this->info("🎉 SEO content generated! Product pages will now show rich meta in Google.");
        return self::SUCCESS;
    }
}
