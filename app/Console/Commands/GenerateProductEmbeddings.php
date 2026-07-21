<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\ProductHead;
use App\Services\AIChatbotService;
use Illuminate\Console\Command;

class GenerateProductEmbeddings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ai:embed-products {--force : Recompute embeddings for all products}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate vector embeddings for catalog products to enable RAG AI search';

    /**
     * Execute the console command.
     */
    public function handle(AIChatbotService $chatbotService): int
    {
        $force = (bool) $this->option('force');

        $query = ProductHead::active();
        if (!$force) {
            $query->whereNull('embedding');
        }

        $products = $query->get();

        if ($products->isEmpty()) {
            $this->info('No products need vector embedding indexing.');
            return Command::SUCCESS;
        }

        $this->info("Generating vector embeddings for {$products->count()} catalog product(s)...");
        $bar = $this->output->createProgressBar($products->count());
        $bar->start();

        $count = 0;
        foreach ($products as $product) {
            $textToEmbed = "{$product->title} {$product->code} {$product->short_desc} {$product->description}";
            $embedding = $chatbotService->generateEmbedding($textToEmbed);

            if (!empty($embedding)) {
                $product->update(['embedding' => $embedding]);
                $count++;
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("✅ Successfully generated and stored vector embeddings for {$count} product(s)!");

        return Command::SUCCESS;
    }
}
