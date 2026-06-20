<?php

namespace App\Livewire;

use App\Models\ProductColor;
use App\Models\ProductHead;
use App\Services\CartManagementService;
use Livewire\Component;

class CartSideBarRow extends Component
{
    public $crt;
    public $slug;
    public $img;
    public $color_title;

    public function mount($crt)
    {
        $is_bundle = $crt['is_bundle'] ?? false;
        if ($is_bundle) {
            $bundle = \App\Models\Bundle::where('slug', $crt['slug'])->first();
            if ($bundle) {
                $bundle_image = $bundle->image;
                if ($bundle->colors->count() > 0 && !empty($crt['color'])) {
                    $bundle_image = $bundle->colors->where('color_name', $crt['color'])->first()->image1 ?? $bundle->image;
                }
                $this->img = env('APP_URL') . '/storage/' . $bundle_image;
                $this->color_title = $crt['color'] ? $crt['color'] : '';
            }
        } else {
            $product = ProductHead::where('slug', $crt['slug'])->first();
            if ($product) {
                $product_image = $product->image;
                if ($product->colors->count() > 0 && !empty($crt['color'])) {
                    $product_image =  $product->colors->where('color_name', $crt['color'])->first()->image1 ?? $product->image;
                }
                $this->img = env('APP_URL') . '/storage/' . $product_image;
                $this->color_title = $crt['color'] ? $crt['color'] : '';
            }
        }
        $this->crt = $crt;
    }

    public function removeItem($slug, $color)
    {
        $is_bundle = $this->crt['is_bundle'] ?? false;
        CartManagementService::removeCartItem($slug, $color, $is_bundle);
        $data = ['type' => 'success', 'message' => 'Item removed successfully.'];
        $this->dispatch('update-cart', data: $data);
        $this->dispatch('cart-refresh');
    }

    public function increaseQty($slug, $color)
    {
        $is_bundle = $this->crt['is_bundle'] ?? false;
        CartManagementService::incrementQuantityToCartItem($slug, $color, $is_bundle);
        $data = ['type' => 'success', 'message' => 'Item quantity increased successfully.'];
        $this->dispatch('update-cart', data: $data);
        $this->dispatch('cart-refresh');
    }

    public function decreaseQty($slug, $color)
    {
        $is_bundle = $this->crt['is_bundle'] ?? false;
        CartManagementService::decrementQuantityToCartItem($slug, $color, $is_bundle);
        $data = ['type' => 'success', 'message' => 'Item quantity decreased successfully.'];
        $this->dispatch('update-cart', data: $data);
        $this->dispatch('cart-refresh');
    }

    public function clearCart()
    {
        CartManagementService::clearCartItems();
        $data = ['type' => 'success', 'message' => 'All items removed successfully.'];
        $this->dispatch('update-cart', data: $data);
        $this->dispatch('cart-refresh');
    }
    public function render()
    {
        return view('livewire.cart-side-bar-row');
    }
}
