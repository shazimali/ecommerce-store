<?php

namespace App\Services;

use App\Models\Category;
use App\Models\ProductColor;
use App\Models\ProductHead;
use App\Models\SubCategory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class ShopService
{
    /**
     * Get filter data (categories and unique colors).
     */
    public function getFilterData(): array
    {
        return [
            'categories' => Category::with('sub_categories')->get(),
            'colors' => ProductColor::distinct()->select('color_name')->get(),
        ];
    }

    /**
     * Get products based on filters.
     */
    public function getProducts(array $filters, int $perPage = 6)
    {
        $query = ProductHead::query()->active();

        $this->applyFilters($query, $filters);
        $this->applySorting($query, $filters['sort_by'] ?? null);

        return $query->orderBy('order', 'ASC')->paginate($perPage);
    }

    /**
     * Apply filters to the product query.
     */
    protected function applyFilters(Builder $query, array $filters): void
    {
        // Category Filter
        if (!empty($filters['category']) && $filters['category'] !== 'all') {
            $category = Category::where('slug', $filters['category'])->with('sub_categories')->first();
            if ($category) {
                $subCatIds = $category->sub_categories->pluck('id');
                $query->whereHas('sub_categories', function ($q) use ($subCatIds) {
                    $q->whereIn('sub_category_id', $subCatIds);
                });
            }
        }

        // Sub-Category Filter
        if (!empty($filters['sub_category'])) {
            $subCategory = SubCategory::where('slug', $filters['sub_category'])->first();
            if ($subCategory) {
                $query->whereHas('sub_categories', function ($q) use ($subCategory) {
                    $q->where('sub_category_id', $subCategory->id);
                });
            }
        }

        // Color Filter
        if (!empty($filters['color'])) {
            $query->whereHas('colors', function ($q) use ($filters) {
                $q->where('color_name', $filters['color']);
            });
        }

        // Price Range Filter
        if (!empty($filters['price_from']) || !empty($filters['price_to'])) {
            $query->whereHas('price_detail', function ($q) use ($filters) {
                if (!empty($filters['price_from'])) {
                    $q->where('price', '>=', $filters['price_from']);
                }
                if (!empty($filters['price_to'])) {
                    $q->where('price', '<=', $filters['price_to']);
                }
            });
        }

        // Search Filter
        if (!empty($filters['search'])) {
            $searchTerm = $filters['search'];
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('short_desc', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        // Rating Filter (Placeholder for future implementation)
        if (!empty($filters['rating'])) {
            // Logic for rating filtering
        }
    }

    /**
     * Apply sorting to the product query.
     */
    protected function applySorting(Builder $query, ?string $sortBy): void
    {
        if (!$sortBy) {
            return;
        }

        switch ($sortBy) {
            case 'featured':
                $query->featured();
                break;
            case 'new':
                $query->new();
                break;
            case 'trending':
                $query->trending();
                break;
            case 'sale':
                $query->whereHas('price_detail', function ($q) {
                    $today = Carbon::today();
                    $q->whereDate('discount_from', '<=', $today)
                      ->whereDate('discount_to', '>=', $today);
                });
                break;
        }
    }
}
