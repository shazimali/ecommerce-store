<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\ProductHead;
use App\Services\AIChatbotService;
use Livewire\Component;

class GlobalSearch extends Component
{
    public string $search = '';

    public function render()
    {
        $products = collect();

        if (strlen($this->search) >= 2) {
            // ── Step 1: SQL candidate fetch (wider net for semantic re-ranking) ──
            $candidates = ProductHead::active()
                ->where(function ($q) {
                    $q->where('title',      'LIKE', '%' . $this->search . '%')
                      ->orWhere('short_desc', 'LIKE', '%' . $this->search . '%')
                      ->orWhere('code',       'LIKE', '%' . $this->search . '%');
                })
                ->with(['price_detail'])
                ->limit(50)
                ->get();

            // ── Step 2: Semantic re-ranking using embeddings (if available) ─────
            if ($candidates->isNotEmpty() && $candidates->contains(fn ($p) => !empty($p->embedding))) {
                /** @var AIChatbotService $chatbot */
                $chatbot        = app(AIChatbotService::class);
                $queryEmbedding = $chatbot->generateEmbedding($this->search);

                $products = $candidates
                    ->sortByDesc(function ($product) use ($chatbot, $queryEmbedding) {
                        if (empty($product->embedding) || !is_array($product->embedding)) {
                            return 0.0;
                        }
                        return $chatbot->cosineSimilarity($queryEmbedding, $product->embedding);
                    })
                    ->take(10)
                    ->values();
            } else {
                // Fallback: no embeddings yet — use the SQL results directly
                $products = $candidates->take(10);
            }
        }

        return view('livewire.global-search', ['products' => $products]);
    }
}
