<?php

namespace App\Livewire;

use App\Services\CartManagementService;
use Livewire\Component;
use Livewire\Attributes\On;

class MobileCartSideBar extends Component
{
    public $cart_count = 0;
    public $cartItems = [];
    public $sub_total = 0;

    #[On('cart-refresh')]
    public function mount()
    {
        $this->cart_count = count(CartManagementService::getCartItemsFromCookies());
        $this->cartItems = CartManagementService::getCartItemsFromCookies();
        $this->sub_total = CartManagementService::calculateGrandTotal($this->cartItems);
    }
    #[On('update-cart')]
    public function updateCart($data)
    {
        $this->cart_count = count(CartManagementService::getCartItemsFromCookies());
        $this->dispatch(
            'alert',
            type: $data['type'],
            title: $data['message'],
        );
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
        return view('livewire.mobile-cart-side-bar');
    }
}
