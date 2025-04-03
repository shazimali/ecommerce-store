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
        $this->cartItems = CartManagementService::getCartItemsFromCookies();
        $this->sub_total = CartManagementService::calculateGrandTotal($this->cartItems);
    }

    // public function removeItem($slug){
    //     CartManagementService::removeCartItem($slug);
    //     $data = ['type' => 'success', 'message' => 'Item removed successfully.'];
    //     $this->dispatch('update-cart',data:$data);
    // }

    // public function increaseQty($slug){
    //     CartManagementService::incrementQuantityToCartItem($slug);
    //     $data = ['type' => 'success', 'message' => 'Item quantity increased successfully.'];
    //     $this->dispatch('update-cart',data:$data);
    // }

    // public function decreaseQty($slug){
    //     CartManagementService::decrementQuantityToCartItem($slug);
    //     $data = ['type' => 'success', 'message' => 'Item decreased decreased successfully.'];
    //     $this->dispatch('update-cart',data:$data);
    // }

    public function clearCart()
    {
        CartManagementService::clearCartItems();
        $data = ['type' => 'success', 'message' => 'All items are removed successfully.'];
        $this->dispatch('update-cart', data: $data);
        $this->dispatch('cart-refresh');
    }

    public function render()
    {
        return view('livewire.cart');
    }
}
