<?php

namespace App\Livewire;

use App\Services\CartManagementService;
use Livewire\Component;
use Livewire\Attributes\On;

class CartSideBar extends Component
{
    public $cart_count = 0;
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
        $this->cart_count = count($this->cartItems);
        $this->sub_total = CartManagementService::calculateGrandTotal($this->cartItems);
    }

    #[On('update-cart')]
    public function updateCart($data)
    {
        $this->refreshCartData();
        if (isset($data['type']) && isset($data['message'])) {
            $this->dispatch(
                'alert',
                type: $data['type'],
                title: $data['message'],
            );
        }
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
        $data = ['type' => 'success', 'message' => 'All items removed successfully.'];
        $this->dispatch('update-cart', data: $data);
        $this->dispatch('cart-refresh');
    }

    public function render()
    {
        return view('livewire.cart-side-bar');
    }
}
