<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\ProductHead;
use App\Services\AIChatbotService;
use Illuminate\Console\Command;

class GenerateProductEmbeddings extends Command
{
    protected $signature = 'products:generate-embeddings
                            {--force : Re-generate even if embedding already exists}
                            {--limit=0 : Limit number of products to process (0 = all)}';

    protected $aliases = ['ai:embed-products'];

    protected $description = 'Generate and store vector embeddings for all products (used by AI chatbot for semantic search)';

    public function handle(AIChatbotService $chatbotService): int
    {
        $force = (bool) $this->option('force');
        $limit = (int)  $this->option('limit');

        $query = ProductHead::with('sub_categories');

        if (!$force) {
            $query->whereNull('embedding');
        }

        if ($limit > 0) {
            $query->limit($limit);
        }

        $products = $query->get();
        $total    = $products->count();

        if ($total === 0) {
            $this->info('✅ All products already have embeddings. Use --force to regenerate.');
            return self::SUCCESS;
        }

        $this->info("🔄 Generating embeddings for {$total} product(s)...");
        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $success = 0;
        $failed  = 0;

        foreach ($products as $product) {
            // Build a rich text representation for better embedding quality
            $subCatNames = $product->sub_categories->pluck('title')->implode(', ');
            $textToEmbed = implode(' | ', array_filter([
                $product->title,
                $product->code,
                $product->short_desc ? strip_tags((string) $product->short_desc) : null,
                $subCatNames ?: null,
            ]));

            try {
                $embedding = $chatbotService->generateEmbedding($textToEmbed);

                if (!empty($embedding)) {
                    $product->update(['embedding' => $embedding]);
                    $success++;
                } else {
                    $failed++;
                    $this->newLine();
                    $this->warn("⚠️  Empty embedding for: {$product->title}");
                }
            } catch (\Throwable $e) {
                $failed++;
                $this->newLine();
                $this->error("❌ Failed [{$product->title}]: " . $e->getMessage());
            }

            $bar->advance();

            // 300ms delay to avoid rate-limiting on free tier
            usleep(300_000);
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
            $this->warn('Re-run the command to retry failed products (they still have NULL embedding).');
            return self::FAILURE;
        }

        $this->info('🎉 AI chatbot will now use semantic ranking for better product matching!');
        return self::SUCCESS;
    }
}
