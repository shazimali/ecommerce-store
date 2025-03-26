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
        $product = ProductHead::where('slug', $crt['slug'])->first();
        if ($product) {
            $product_image = $product->colors->count() > 0 ? $product->colors->where('color_name', $crt['color'])->first()->image1 : $product->image;
            $this->img = env('APP_URL') . '/storage/' . $product_image;
            $this->color_title = $crt['color'] ? $crt['color'] : '';
        }
        $this->crt = $crt;
    }

    public function removeItem($slug, $color)
    {
        CartManagementService::removeCartItem($slug, $color);
        $data = ['type' => 'success', 'message' => 'Item removed successfully.'];
        $this->dispatch('update-cart', data: $data);
        $this->dispatch('cart-refresh');
    }

    public function increaseQty($slug, $color)
    {
        CartManagementService::incrementQuantityToCartItem($slug, $color);
        $data = ['type' => 'success', 'message' => 'Item quantity increased successfully.'];
        $this->dispatch('update-cart', data: $data);
        $this->dispatch('cart-refresh');
    }

    public function decreaseQty($slug, $color)
    {
        CartManagementService::decrementQuantityToCartItem($slug, $color);
        $data = ['type' => 'success', 'message' => 'Item decreased decreased successfully.'];
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
