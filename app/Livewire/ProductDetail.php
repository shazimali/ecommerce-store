<?php

namespace App\Livewire;

use App\Models\ProductHead;
use App\Models\ProductReview;
use App\Services\CartManagementService;
use App\Services\ProductService;
use Livewire\Component;

class ProductDetail extends Component
{
    public $slug;
    public $product;
    public $reviews = [];
    public $max_rating;
    public $activeImage;
    public $colors;
    public $images;
    public $add_to_cart_active = false;
    public $qty = 1;
    public $current_color;
    public $relatedProducts = [];
    public $badges = [];

    public function mount()
    {
        $this->product = ProductService::getProductDetailBySlug($this->slug);
        $this->reviews = ProductService::getProductReviews($this->product->id);

        $this->activeImage = getWebsiteUrl() . '/storage/' . $this->product->image1;
        $this->colors = $this->product->colors->isNotEmpty() ? $this->product->colors : [];
        $this->current_color = $this->colors ? $this->colors->first()->color_name : '';

        $this->images = [
            $this->product->image1 ? getWebsiteUrl() . '/storage/' . $this->product->image1 : '',
            $this->product->image2 ? getWebsiteUrl() . '/storage/' . $this->product->image2 : '',
            $this->product->image3 ? getWebsiteUrl() . '/storage/' . $this->product->image3 : '',
            $this->product->image4 ? getWebsiteUrl() . '/storage/' . $this->product->image4 : '',
            $this->product->image5 ? getWebsiteUrl() . '/storage/' . $this->product->image5 : '',
        ];

        // Get the product's own sub-category IDs
        $subCategoryIds = $this->product->sub_categories->pluck('id');

        // Get the parent category IDs that this product belongs to (via its sub-categories)
        $categoryIds = $subCategoryIds->isNotEmpty()
            ? \DB::table('category_sub_category')
                ->whereIn('sub_category_id', $subCategoryIds)
                ->pluck('category_id')
                ->unique()
            : collect();

        // ── Related Products ─────────────────────────────────────────────────────
        // Find products that share at least one parent CATEGORY with this product.
        // Try trending first; fall back to all active products in those categories.
        if ($categoryIds->isNotEmpty()) {
            // Collect ALL sub-category IDs that live under the same parent categories
            $siblingSubCategoryIds = \DB::table('category_sub_category')
                ->whereIn('category_id', $categoryIds)
                ->pluck('sub_category_id')
                ->unique();

            $related = ProductHead::active()
                ->trending()
                ->whereHas('sub_categories', function ($q) use ($siblingSubCategoryIds) {
                    $q->whereIn('sub_categories.id', $siblingSubCategoryIds);
                })
                ->where('id', '!=', $this->product->id)
                ->with(['price_detail.country', 'stocks'])
                ->orderBy('order')
                ->get();

            // Fall back to all active (non-trending) products in the same categories
            if ($related->isEmpty()) {
                $related = ProductHead::active()
                    ->whereHas('sub_categories', function ($q) use ($siblingSubCategoryIds) {
                        $q->whereIn('sub_categories.id', $siblingSubCategoryIds);
                    })
                    ->where('id', '!=', $this->product->id)
                    ->with(['price_detail.country', 'stocks'])
                    ->orderBy('order')
                    ->get();
            }

            $this->relatedProducts = $related->toArray();
        } else {
            $this->relatedProducts = [];
        }

        // ── Badges ───────────────────────────────────────────────────────────────
        // Load badges directly from the database based on the product's own
        // sub-categories. No session dependency needed.
        if ($subCategoryIds->isNotEmpty()) {
            $this->badges = \App\Models\Badge::where('status', 'ACTIVE')
                ->whereHas('sub_categories', function ($q) use ($subCategoryIds) {
                    $q->whereIn('sub_categories.id', $subCategoryIds);
                })
                ->get()
                ->toArray();
        } else {
            $this->badges = [];
        }
    }

    public function changeActiveImage($image)
    {
        $this->activeImage = $image;
    }

    public function fetchColorWiseImages($id, $name)
    {
        $color_info = $this->colors->where('id', $id)->first();
        $this->current_color = $name;
        $this->add_to_cart_active = true;
        $this->activeImage = getWebsiteUrl() . '/storage/' . $color_info->image1;
        $this->images = [
            $color_info->image1 ? getWebsiteUrl() . '/storage/' . $color_info->image1 : '',
            $color_info->image2 ? getWebsiteUrl() . '/storage/' . $color_info->image2 : '',
            $color_info->image3 ? getWebsiteUrl() . '/storage/' . $color_info->image3 : '',
            $color_info->image4 ? getWebsiteUrl() . '/storage/' . $color_info->image4 : '',
            $color_info->image5 ? getWebsiteUrl() . '/storage/' . $color_info->image5 : '',
        ];
    }

    public function addToCart($slug)
    {
        // if ($this->add_to_cart_active) {
        CartManagementService::addCartItemsFromProductDetailPage($slug, $this->current_color, $this->qty);
        $data = ['type' => 'success', 'message' => 'Item added successfully.'];
        $this->dispatch('update-cart', data: $data);
        $this->dispatch('cart-refresh');
        // } else {
        //     $this->dispatch(
        //         'alert',
        //         type: 'error',
        //         title: 'Please select at least one color.',
        //     );
        // }
    }
    public function incrementQty($val)
    {
        if ($val > 1) {
            $this->qty = $val;
        }
    }
    public function decrementQty($val)
    {
        if ($val > 0) {
            $this->qty = $val;
        }
    }

    public function render()
    {
        if ($this->product) {
            return view('livewire.product-detail');
        } else {
            return abort('404');
        }
    }
}
