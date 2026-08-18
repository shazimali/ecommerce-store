<?php

namespace App\Livewire;

use App\Services\CartManagementService;
use Livewire\Attributes\On;
use Livewire\Component;

class Cart extends Component
{
    public $cartItems = [];
    public $sub_total = 0;

    #[On('cart-refresh')]
    public function mount()
    {
        $this->refreshCartData();
    }

    protected function refreshCartData()
    {
        $this->cartItems = CartManagementService::getCartItemsFromCookies();
        $this->sub_total = CartManagementService::calculateGrandTotal($this->cartItems);
    }

    public function removeItem($slug, $color, $is_bundle = false)
    {
        CartManagementService::removeCartItem($slug, (string)$color, (bool)$is_bundle);
        $this->refreshCartData();
        $data = ['type' => 'success', 'message' => 'Item removed successfully.'];
        $this->dispatch('update-cart', data: $data);
        $this->dispatch('cart-refresh');
    }

    public function increaseQty($slug, $color, $is_bundle = false)
    {
        CartManagementService::incrementQuantityToCartItem($slug, (string)$color, (bool)$is_bundle);
        $this->refreshCartData();
        $data = ['type' => 'success', 'message' => 'Item quantity increased successfully.'];
        $this->dispatch('update-cart', data: $data);
        $this->dispatch('cart-refresh');
    }

    public function decreaseQty($slug, $color, $is_bundle = false)
    {
        CartManagementService::decrementQuantityToCartItem($slug, (string)$color, (bool)$is_bundle);
        $this->refreshCartData();
        $data = ['type' => 'success', 'message' => 'Item quantity decreased successfully.'];
        $this->dispatch('update-cart', data: $data);
        $this->dispatch('cart-refresh');
    }

    public function clearCart()
    {
        CartManagementService::clearCartItems();
        $this->refreshCartData();
        $data = ['type' => 'success', 'message' => 'All items are removed successfully.'];
        $this->dispatch('update-cart', data: $data);
        $this->dispatch('cart-refresh');
    }

    public function render()
    {
        return view('livewire.cart');
    }
}
