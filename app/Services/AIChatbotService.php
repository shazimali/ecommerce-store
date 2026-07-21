<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Order;
use App\Models\ProductHead;
use Illuminate\Support\Facades\Http;

class AIChatbotService
{
    public function chat(string $userPrompt, array $history = []): string
    {
        $trimmedPrompt = trim($userPrompt);

        // ── Instant greeting response ──────────────────────────────────────────
        if (preg_match('/^\s*(?:hi|hey|hello|hy|hlo|greetings|good\s+morning|good\s+evening|good\s+afternoon|assalam|aoa|slam|a\.o\.a)\b/i', $trimmedPrompt)) {
            return "👋 Hi there! I'm your Everyday Plastic AI Assistant. Ask me about products, catalog prices, or track your order status!";
        }

        // ── Human handoff intent detection ─────────────────────────────────────
        if (preg_match('/\b(?:human|agent|real\s+person|support\s+team|talk\s+to\s+someone|frustrated|not\s+working|speak\s+to\s+someone|need\s+help\s+urgently|contact\s+support|customer\s+service)\b/i', $trimmedPrompt)) {
            $whatsappNumber = function_exists('getSettingVal') ? getSettingVal('whats_app') : '923363413244';
            $phone = function_exists('website') && website() ? website()->phone : '0336 3413244';
            return "No problem at all! 😊 Our friendly support team is ready to assist you right away.\n\n[WHATSAPP: {$whatsappNumber}] [PHONE: {$phone}]\n\nWe typically respond within a few minutes. We're happy to help! 💬";
        }

        // ── Order tracking request without order ID/number ─────────────────────
        if (preg_match('/^\s*(?:track\s+my\s+order|track\s+order|order\s+status|check\s+order|where\s+is\s+my\s+order)\s*$/i', $trimmedPrompt)) {
            return "📦 I can certainly help you track your order!\n\nPlease reply with your **Order ID**, **Order Code** (e.g. *#12*), or your **Tracking Number** so I can look up the details for you. 😊";
        }

        $context = $this->buildDatabaseContext($userPrompt);

        $apiKey = config('services.openrouter.api_key');
        $model = config('services.openrouter.model', 'google/gemini-2.0-flash-exp:free');

        // If no API key configured, provide instant intelligent database fallback
        if (empty($apiKey)) {
            return $this->getFallbackResponse($userPrompt, $context);
        }

        $whatsappNumber = function_exists('getSettingVal') ? getSettingVal('whats_app') : '923363413244';
        $phone = function_exists('website') && website() ? website()->phone : '0336 3413244';

        try {
            $systemPrompt = "You are Everyday Assistant, the warm, polite, and official shopping assistant for 'Everyday Plastic' (Everyday Shops). "
                . "Always respond in a friendly, respectful, and professional tone using natural emojis! "
                . "When recommending or listing products, format each product in a neat, easy-to-read bullet block:\n"
                . "🛍️ **Product Title**\n"
                . "• Price: **Rs. X,XXX**\n"
                . "• Details: Short summary\n"
                . "[URL: /products/slug]\n\n"
                . "When answering order tracking inquiries:\n"
                . "• State the current status clearly and politely.\n"
                . "• Explain what the next step/stage is for that status (e.g. Pending -> Processing & Packing -> Dispatched -> Out for Delivery -> Delivered).\n"
                . "• Provide an estimated delivery timeline (Standard delivery takes 3 to 5 business days across Pakistan).\n"
                . "• Keep the tone very polite, helpful, and reassuring.\n\n"
                . "Use **bold** for important values. Use • bullet points for lists. Keep responses concise and helpful. "
                . "If you cannot answer a specific question, or if the user needs human assistance, suggest contacting our support team using tags [WHATSAPP: {$whatsappNumber}] and [PHONE: {$phone}]. "
                . "Store Info: Everyday Plastic offers premium plastic homeware, kitchen storage, baby furniture, shoe racks, and home organizers in Pakistan. Free delivery on orders above Rs. 3,999. "
                . "Return Policy: 7-day easy returns on all products. Terms apply.";

            if (!empty($context)) {
                $systemPrompt .= "\n\n[Real-time Database Context]\n" . $context;
            }

            $messages = [
                ['role' => 'system', 'content' => $systemPrompt],
            ];

            foreach ($history as $msg) {
                if (isset($msg['role'], $msg['content'])) {
                    $messages[] = [
                        'role' => $msg['role'] === 'user' ? 'user' : 'assistant',
                        'content' => (string) $msg['content'],
                    ];
                }
            }

            $messages[] = ['role' => 'user', 'content' => $userPrompt];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'HTTP-Referer'  => config('app.url'),
                'X-Title'       => 'Everyday Shops AI Assistant',
            ])->timeout(12)->post('https://openrouter.ai/api/v1/chat/completions', [
                'model'      => $model,
                'messages'   => $messages,
                'max_tokens' => 450,
            ]);

            if ($response->successful()) {
                $content = $response->json('choices.0.message.content');
                if (!empty($content)) {
                    return trim($content);
                }
            }

            return $this->getFallbackResponse($userPrompt, $context);

        } catch (\Throwable $e) {
            return $this->getFallbackResponse($userPrompt, $context);
        }
    }

    public function buildDatabaseContext(string $userPrompt): string
    {
        $contextParts = [];

        // 1. Order Tracking Detection (with items breakdown)
        if (preg_match('/(?:order|track|code|status|#)\s*#?([A-Za-z0-9-]+)/i', $userPrompt, $matches) || preg_match('/\b\d{1,10}\b/', $userPrompt, $matches)) {
            $identifier = trim($matches[1] ?? $matches[0]);

            $order = Order::with(['detail'])
                ->where('id', $identifier)
                ->orWhere('order_id', $identifier)
                ->orWhere('track_number', $identifier)
                ->first();

            if ($order) {
                $status = strtoupper((string) ($order->status ?? 'Processing'));
                $total = number_format((float) ($order->total ?? 0));
                $track = $order->track_number ?: 'N/A';
                $orderInfo = "ORDER INFO: Found Order #{$order->id} (Code: {$order->order_id}). Status: {$status}. Total: Rs. {$total}. Tracking Number: {$track}. Created: {$order->created_at?->format('d M Y')}.";

                // Include items breakdown
                if ($order->detail && $order->detail->count() > 0) {
                    $itemLines = [];
                    foreach ($order->detail as $item) {
                        $itemName = $item->product_title ?? $item->title ?? 'Item';
                        $qty = $item->qty ?? $item->quantity ?? 1;
                        $itemLines[] = "  • {$qty}× {$itemName}";
                    }
                    $orderInfo .= "\nORDER ITEMS:\n" . implode("\n", $itemLines);
                }

                $contextParts[] = $orderInfo;
            }
        }

        // 2. Policy / Pages Inquiry Detection
        $policyKeywords = ['return', 'refund', 'shipping', 'delivery', 'policy', 'terms', 'condition', 'privacy', 'exchange', 'warranty', 'guarantee', 'complaint', 'cancel'];
        $isPolicyQuery = false;
        foreach ($policyKeywords as $kw) {
            if (stripos($userPrompt, $kw) !== false) {
                $isPolicyQuery = true;
                break;
            }
        }

        if ($isPolicyQuery) {
            try {
                $pages = \App\Models\Page::active()->get();
                $relevantPage = null;
                foreach ($pages as $page) {
                    foreach ($policyKeywords as $kw) {
                        if (stripos($userPrompt, $kw) !== false && (stripos($page->title, $kw) !== false || stripos($page->slug, $kw) !== false)) {
                            $relevantPage = $page;
                            break 2;
                        }
                    }
                }

                // Fallback: use first policy-looking page
                if (!$relevantPage) {
                    $relevantPage = $pages->first();
                }

                if ($relevantPage) {
                    $pageContent = strip_tags((string) ($relevantPage->content ?? ''));
                    $pageContent = trim(preg_replace('/\s+/', ' ', $pageContent));
                    $summary = substr($pageContent, 0, 500);
                    $contextParts[] = "STORE POLICY — {$relevantPage->title}:\n{$summary}\n[URL: /pages/{$relevantPage->slug}]";
                }
            } catch (\Throwable $e) {
                // Graceful fallback — policy data unavailable
            }
        }

        // 3. Product Search & Catalog Inquiry Detection
        $keywords = ['product', 'item', 'buy', 'price', 'rack', 'chair', 'storage', 'kitchen', 'box', 'table', 'shelf', 'organizer', 'bottle', 'show', 'list', 'detail', 'catalog', 'all', 'have', 'collection', 'category', 'best', 'seller', 'popular', 'trending', 'new', 'featured'];
        $isProductQuery = false;
        foreach ($keywords as $kw) {
            if (stripos($userPrompt, $kw) !== false) {
                $isProductQuery = true;
                break;
            }
        }

        if ($isProductQuery) {
            $cleaned = trim((string) preg_replace('/\b(?:please|kindly|can|you|find|search|show|get|buy|price|detail|details|of|for|about|me|any|some|products|product|items|item|all|list|what|have)\\b/i', '', $userPrompt));
            $searchQuery = trim((string) preg_replace('/\s+/', ' ', $cleaned));

            // Best sellers / trending / new detection
            $isTrending = preg_match('/\b(?:best|popular|trending|top|seller|bestsell)\b/i', $userPrompt);
            $isNew = preg_match('/\b(?:new|latest|recent|fresh)\b/i', $userPrompt);
            $isFeatured = preg_match('/\b(?:featured|special|recommended|suggest)\b/i', $userPrompt);

            $query = ProductHead::active()->with(['price_detail', 'price_detail.country', 'reviews']);

            if ($isTrending) {
                $query->where('is_trending', 1)->orWhere('is_featured', 1);
            } elseif ($isNew) {
                $query->where('is_new', 1);
            } elseif ($isFeatured) {
                $query->where('is_featured', 1);
            } elseif (strlen($searchQuery) >= 2 && !in_array(strtolower($searchQuery), ['all', 'list', 'show', 'products', 'items', 'have', 'store', 'seller', 'best', 'trending', 'category'])) {
                // Specific keyword search
                $terms = array_filter(explode(' ', $searchQuery));
                $query->where(function ($sub) use ($searchQuery, $terms) {
                    $sub->where('title', 'LIKE', "%{$searchQuery}%")
                        ->orWhere('code', 'LIKE', "%{$searchQuery}%")
                        ->orWhere('short_desc', 'LIKE', "%{$searchQuery}%");

                    foreach ($terms as $term) {
                        if (strlen($term) >= 3) {
                            $sub->orWhere('title', 'LIKE', "%{$term}%")
                                ->orWhere('short_desc', 'LIKE', "%{$term}%");
                        }
                    }
                });
            }

            $products = $query->orderBy('order', 'ASC')->take(6)->get();

            // If specific search yields 0 matches, fallback to top active catalog products
            if ($products->isEmpty()) {
                $products = ProductHead::active()->with(['price_detail', 'price_detail.country', 'reviews'])->orderBy('order', 'ASC')->take(6)->get();
            }

            // RAG Semantic Ranking using Cosine Similarity if embeddings exist
            if ($products->count() > 0 && $products->contains(fn($p) => !empty($p->embedding))) {
                $queryEmbedding = $this->generateEmbedding($userPrompt);
                $products = $products->sortByDesc(function ($product) use ($queryEmbedding) {
                    if (empty($product->embedding) || !is_array($product->embedding)) {
                        return 0.0;
                    }
                    return $this->cosineSimilarity($queryEmbedding, $product->embedding);
                })->values();
            }

            // Fetch Store Categories & Collections
            try {
                $categories = \App\Models\Category::take(8)->get();
                if ($categories->count() > 0) {
                    $catList = [];
                    foreach ($categories as $cat) {
                        $catList[] = "• 📁 **{$cat->title}** [URL: /categories/{$cat->slug}]";
                    }
                    $catList[] = "• 🔗 **Browse Full Store Catalog** [URL: /shop]";
                    $contextParts[] = "STORE CATEGORIES & SHOP COLLECTIONS:\n" . implode("\n", $catList);
                }
            } catch (\Throwable $e) {
                // Graceful fallback
            }

            if ($products->count() > 0) {
                $productList = [];
                foreach ($products->take(6) as $p) {
                    $price = $p->price_detail?->price ? 'Rs. ' . number_format((float) $p->price_detail->price) : 'Price available on store';
                    $desc = $p->short_desc ? trim(substr(strip_tags((string)$p->short_desc), 0, 90)) . '...' : 'Quality plastic homeware item';
                    $imageUrl = $p->image ? '/storage/' . $p->image : '';

                    // Reviews summary
                    $reviewSummary = '';
                    if ($p->reviews && $p->reviews->count() > 0) {
                        $avgRating = round($p->reviews->avg('rating'), 1);
                        $reviewCount = $p->reviews->count();
                        $reviewSummary = "\n• Rating: ⭐ {$avgRating}/5 ({$reviewCount} reviews)";
                    }

                    $productList[] = "🛍️ **{$p->title}**\n• Price: **{$price}**{$reviewSummary}\n• Details: {$desc}\n[PRODUCT_CARD: {$p->title}|{$price}|{$imageUrl}|/products/{$p->slug}]";
                }
                $contextParts[] = "FEATURED/MATCHING PRODUCTS IN STORE:\n" . implode("\n\n", $productList);
            }
        }

        return implode("\n\n", $contextParts);
    }

    /**
     * Generate vector embedding for input text.
     * Uses OpenRouter API if available, or falls back to term frequency vectorization.
     */
    public function generateEmbedding(string $text): array
    {
        $apiKey = config('services.openrouter.api_key');

        if (!empty($apiKey)) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'HTTP-Referer'  => config('app.url'),
                    'X-Title'       => 'Everyday Shops AI Embeddings',
                ])->timeout(8)->post('https://openrouter.ai/api/v1/embeddings', [
                    'model' => 'openai/text-embedding-3-small',
                    'input' => $text,
                ]);

                if ($response->successful()) {
                    $vec = $response->json('data.0.embedding');
                    if (is_array($vec) && count($vec) > 0) {
                        return $vec;
                    }
                }
            } catch (\Throwable $e) {
                // Fallback to local vector generator on network exception
            }
        }

        return $this->generateLocalFallbackVector($text);
    }

    /**
     * Calculate cosine similarity between two vector float arrays.
     */
    public function cosineSimilarity(array $vecA, array $vecB): float
    {
        $count = min(count($vecA), count($vecB));
        if ($count === 0) {
            return 0.0;
        }

        $dotProduct = 0.0;
        $normA = 0.0;
        $normB = 0.0;

        for ($i = 0; $i < $count; $i++) {
            $valA = (float) $vecA[$i];
            $valB = (float) $vecB[$i];
            $dotProduct += $valA * $valB;
            $normA += $valA * $valA;
            $normB += $valB * $valB;
        }

        if ($normA <= 0 || $normB <= 0) {
            return 0.0;
        }

        return $dotProduct / (sqrt($normA) * sqrt($normB));
    }

    /**
     * Local fallback vector generator for testing / offline environments.
     */
    private function generateLocalFallbackVector(string $text): array
    {
        $vector = array_fill(0, 64, 0.0);
        $words = array_unique(explode(' ', strtolower(preg_replace('/[^a-z0-9\s]/i', '', $text))));

        foreach ($words as $word) {
            if (strlen($word) > 2) {
                $hash = crc32($word);
                $index = abs($hash) % 64;
                $vector[$index] += 1.0;
            }
        }

        $magnitude = sqrt(array_sum(array_map(fn($v) => $v * $v, $vector)));
        if ($magnitude > 0) {
            return array_map(fn($v) => $v / $magnitude, $vector);
        }

        return $vector;
    }

    private function getFallbackResponse(string $userPrompt, string $context): string
    {
        $whatsappNumber = function_exists('getSettingVal') ? getSettingVal('whats_app') : '923363413244';
        $phone = function_exists('website') && website() ? website()->phone : '0336 3413244';

        if (!empty($context)) {
            if (str_contains($context, 'ORDER INFO:')) {
                preg_match('/ORDER INFO: (.*?)(?:\n|$)/s', $context, $m);
                $orderSummary = $m[1] ?? '';
                $itemsSection = '';
                if (str_contains($context, 'ORDER ITEMS:')) {
                    preg_match('/ORDER ITEMS:\n(.*)/s', $context, $itemMatch);
                    $itemsSection = "\n\n📦 **Ordered Items:**\n" . ($itemMatch[1] ?? '');
                }

                // Determine next step and ETA based on status
                $statusGuidance = "• **Status:** Processing\n• **Next Step:** Quality check & parcel packing\n• **Estimated Delivery:** 3 to 5 business days";
                if (str_contains($orderSummary, 'DISPATCHED') || str_contains($orderSummary, 'SHIPPED')) {
                    $statusGuidance = "• **Status:** Dispatched\n• **Next Step:** Handover to courier for out for delivery\n• **Estimated Delivery:** 1 to 3 business days";
                } elseif (str_contains($orderSummary, 'DELIVERED')) {
                    $statusGuidance = "• **Status:** Delivered 🎉\n• **Next Step:** Completed! Thank you for shopping with Everyday Plastic.";
                } elseif (str_contains($orderSummary, 'CANCELLED')) {
                    $statusGuidance = "• **Status:** Cancelled\n• **Next Step:** Please contact support if you wish to re-order.";
                }

                return "Thank you for reaching out! Here is the latest update on your order:\n\n**{$orderSummary}**\n\n{$statusGuidance}{$itemsSection}\n\nIf you need further assistance with your shipment, our team is always happy to help:\n\n[WHATSAPP: {$whatsappNumber}] [PHONE: {$phone}]";
            }

            if (str_contains($context, 'STORE POLICY')) {
                $cleanPolicy = preg_replace('/STORE POLICY — [^:]+:\n/', '', $context);
                return "Here is the information you need: 📄\n\n{$cleanPolicy}\n\nFor more clarification, our team is happy to assist:\n\n[WHATSAPP: {$whatsappNumber}] [PHONE: {$phone}]";
            }

            if (str_contains($context, 'MATCHING PRODUCTS') || str_contains($context, 'STORE CATEGORIES')) {
                $cleanContext = str_replace(["FEATURED/MATCHING PRODUCTS IN STORE:\n", "STORE CATEGORIES & SHOP COLLECTIONS:\n"], '', $context);
                return "Here are our store categories and top catalog recommendations:\n\n" . $cleanContext . "\n\nFor custom inquiries or further assistance, connect with our support team:\n\n[WHATSAPP: {$whatsappNumber}] [PHONE: {$phone}]";
            }
        }

        return "I'm sorry, I couldn't find exact details for your request right now. 😊\n\nFor instant assistance, please connect with our support team:\n\n[WHATSAPP: {$whatsappNumber}] [PHONE: {$phone}]";
    }
}
