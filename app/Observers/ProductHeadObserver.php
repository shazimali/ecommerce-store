<?php

namespace App\Observers;

use App\Models\ProductHead;
use Illuminate\Support\Facades\Cache;

class ProductHeadObserver
{
    /**
     * Clear product-related caches when a product is created or updated.
     */
    public function saved(ProductHead $product): void
    {
        $this->clearProductCaches($product);
    }

    /**
     * Clear product-related caches when a product is deleted.
     */
    public function deleted(ProductHead $product): void
    {
        $this->clearProductCaches($product);
    }

    /**
     * Flush all caches related to a specific product and aggregate lists.
     */
    protected function clearProductCaches(ProductHead $product): void
    {
        // Clear the individual product detail caches
        Cache::forget('product_detail_' . $product->slug);
        Cache::forget('product_reviews_' . $product->id);

        // Clear home page caches for all websites (blast all website IDs 1-20 to be safe)
        foreach (range(1, 20) as $websiteId) {
            Cache::forget('home_page_' . $websiteId);
        }

        // Clear new arrivals aggregate cache
        Cache::forget('new_arrivals');
    }
}
