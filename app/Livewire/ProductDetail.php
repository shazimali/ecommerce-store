<?php

namespace App\Livewire;

use App\Models\ProductHead;
use Livewire\Component;

class ProductDetail extends Component
{
    public $slug;
    public $product;
    public $reviews;
    public $max_rating;
    public $activeImage;
    public $colors;
    public $images;
    public $add_to_cart_active = false;
    public $qty = 1;
    public $current_color;

    public function mount()
    {
        $this->product = ProductHead::where('slug', $this->slug)->first();
        $this->activeImage = env('APP_URL') . 'storage/' . $this->product->image;
        $this->colors = $this->product->colors;
        $this->current_color = $this->colors->first()->color_name;
        $this->images = [
            $this->colors->first()->image1 ? env('APP_URL') . 'storage/' . $this->colors->first()->image1  : '',
            $this->colors->first()->image2 ? env('APP_URL') . 'storage/' . $this->colors->first()->image2  : '',
            $this->colors->first()->image3 ? env('APP_URL') . 'storage/' . $this->colors->first()->image3  : '',
            $this->colors->first()->image4 ? env('APP_URL') . 'storage/' . $this->colors->first()->image4  : '',
            $this->colors->first()->image5 ? env('APP_URL') . 'storage/' . $this->colors->first()->image5  : '',
        ];
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
        $this->activeImage =  env('APP_URL') . 'storage/' . $color_info->image1;
        $this->images = [
            $color_info->image1 ? env('APP_URL') . 'storage/' . $color_info->image1  : '',
            $color_info->image2 ? env('APP_URL') . 'storage/' . $color_info->image2  : '',
            $color_info->image3 ? env('APP_URL') . 'storage/' . $color_info->image3  : '',
            $color_info->image4 ? env('APP_URL') . 'storage/' . $color_info->image4  : '',
            $color_info->image5 ? env('APP_URL') . 'storage/' . $color_info->image5  : '',
        ];
    }

    public function addToCart($slug)
    {
        // if ($this->add_to_cart_active) {
        //     CartManagement::addCartItemsFromProductDetailPage($slug, $this->current_color_id, $this->qty);
        //     $data = ['type' => 'success', 'message' => 'Item added successfully.'];
        //     $this->dispatch('update-cart', data: $data);
        //     $this->dispatch('cart-refresh');
        // } else {
        //     $this->dispatch(
        //         'alert',
        //         type: 'error',
        //         title: 'Please select at least one color.',
        //     );
        // }
    }

    public function render()
    {
        return view('livewire.product-detail');
    }
}
