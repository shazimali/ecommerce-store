<?php

namespace App\Livewire;

use App\Models\Bundle;
use App\Models\ProductReview;
use App\Services\CartManagementService;
use Livewire\Component;

class BundleDetail extends Component
{
    public $slug;
    public $bundle;
    public $reviews = [];
    public $activeImage;
    public $colors;
    public $images;
    public $add_to_cart_active = false;
    public $qty = 1;
    public $current_color;
    public $relatedBundles = [];

    public function mount()
    {
        $this->bundle = Bundle::where('slug', $this->slug)->with(['colors', 'price_detail.country'])->first();
        if (!$this->bundle) {
            abort(404);
        }

        $this->reviews = ProductReview::where('bundle_id', $this->bundle->id)->where('status', 'ACTIVE')->with('user')->get();

        $this->activeImage = getWebsiteUrl() . '/storage/' . $this->bundle->image1;
        $this->colors = $this->bundle->colors->isNotEmpty() ? $this->bundle->colors : [];
        $this->current_color = $this->colors->isNotEmpty() ? $this->colors->first()->color_name : '';

        $this->images = [
            $this->bundle->image1 ? getWebsiteUrl() . '/storage/' . $this->bundle->image1 : '',
            $this->bundle->image2 ? getWebsiteUrl() . '/storage/' . $this->bundle->image2 : '',
            $this->bundle->image3 ? getWebsiteUrl() . '/storage/' . $this->bundle->image3 : '',
            $this->bundle->image4 ? getWebsiteUrl() . '/storage/' . $this->bundle->image4 : '',
            $this->bundle->image5 ? getWebsiteUrl() . '/storage/' . $this->bundle->image5 : '',
        ];

        // Related Bundles
        $this->relatedBundles = Bundle::active()
            ->where('id', '!=', $this->bundle->id)
            ->with(['price_detail.country'])
            ->orderBy('order')
            ->get()
            ->toArray();
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
        CartManagementService::addCartItemsFromProductDetailPage($slug, $this->current_color, $this->qty, true);
        $data = ['type' => 'success', 'message' => 'Bundle added to cart successfully.'];
        $this->dispatch('update-cart', data: $data);
        $this->dispatch('cart-refresh');
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
        if ($this->bundle) {
            return view('livewire.bundle-detail');
        } else {
            return abort('404');
        }
    }
}
