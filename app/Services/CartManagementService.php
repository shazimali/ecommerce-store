<?php

namespace App\Services;

use App\Models\ProductHead;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;

class CartManagementService
{

    static public function addCartItems($slug, $color)
    {
        $cart_items = self::getCartItemsFromCookies();

        $existing_items = null;

        foreach ($cart_items as $key => $item) {
            if ($item['slug'] == $slug && $item['color'] == $color) {
                $existing_items = $key;
                break;
            }
        }

        if ($existing_items !== null) {
            $cart_items[$existing_items]['quantity']++;
            $cart_items[$existing_items]['total_amount'] = $cart_items[$existing_items]['quantity'] * $cart_items[$existing_items]['unit_amount'];
        } else {
            $product = ProductHead::where('slug', $slug)->first();
            $price = $product->price_detail->price;
            if ($product->price_detail->discount > 0 &&  ($product->price_detail->discount_from >= Carbon::today()->toDateString() || $product->price_detail->discount_to >= Carbon::today()->toDateString())) {
                $price = $product->price_detail->price - ($product->price_detail->price / 100 * $product->price_detail->discount);
            }

            $cart_items[] = [
                'slug' => $product->slug,
                'color' => $color ? $color : '',
                'title' => $product->title,
                'currency' => $product->price_detail->country->currency,
                'image' => $product->colors->count() > 0 ? $product->colors->where('color_name', $color)->first()->image1 : $product->image,
                'quantity' => 1,
                'unit_amount' => $price,
                'total_amount' => $price
            ];
        }

        self::addCartItemsToCookie($cart_items);
        return count($cart_items);
    }

    static public function addCartItemsFromProductDetailPage($slug, $color, $qty)
    {
        $cart_items = self::getCartItemsFromCookies();

        $existing_items = null;

        foreach ($cart_items as $key => $item) {
            if ($item['slug'] == $slug && $item['color'] == $color) {
                $existing_items = $key;
                break;
            }
        }

        if ($existing_items !== null) {
            $cart_items[$existing_items]['quantity'] = $cart_items[$existing_items]['quantity'] + $qty;
            $cart_items[$existing_items]['total_amount'] = $cart_items[$existing_items]['quantity'] * $cart_items[$existing_items]['unit_amount'];
        } else {
            $product = ProductHead::where('slug', $slug)->first();
            $price = $product->price_detail->price;
            if ($product->price_detail->discount > 0 &&  ($product->price_detail->discount_from >= Carbon::today()->toDateString() || $product->price_detail->discount_to >= Carbon::today()->toDateString())) {
                $price = $product->price_detail->price - ($product->price_detail->price / 100 * $product->price_detail->discount);
            }
            $cart_items[] = [
                'slug' => $product->slug,
                'color' => $color,
                'title' => $product->title,
                'currency' => $product->price_detail->country->currency,
                'image' => $product->colors->count() > 0 ? $product->colors->where('color_name', $color)->first()->image1 : $product->image,
                'quantity' => $qty,
                'unit_amount' => $price,
                'total_amount' => round($qty * $price)
            ];
        }

        self::addCartItemsToCookie($cart_items);
        return count($cart_items);
    }

    static public function removeCartItem($slug, $color)
    {
        $cart_items = self::getCartItemsFromCookies();

        foreach ($cart_items as $key => $item) {
            if ($item['slug']  ==  $slug && $item['color'] == $color) {
                unset($cart_items[$key]);
            }
        }

        self::addCartItemsToCookie($cart_items);

        return $cart_items;
    }

    static public function addCartItemsToCookie($cart_items)
    {
        Cookie::queue('cart_items', json_encode($cart_items), 60 * 24 * 30);
    }

    static public function getCartItemsFromCookies()
    {
        $cart_items = json_decode(Cookie::get('cart_items'), true);
        if (!$cart_items) {
            $cart_items = [];
        }

        return $cart_items;
    }

    static public function clearCartItems()
    {
        Cookie::queue(Cookie::forget('cart_items'));
    }

    static public function incrementQuantityToCartItem($slug, $color)
    {
        $cart_items = self::getCartItemsFromCookies();

        foreach ($cart_items as $key => $item) {
            if ($item['slug'] == $slug  && $item['color'] == $color) {
                $cart_items[$key]['quantity'] += 1;
                $cart_items[$key]['total_amount'] = round($cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount']);
            }
        }
        self::addCartItemsToCookie($cart_items);
        return $cart_items;
    }

    static public function decrementQuantityToCartItem($slug, $color)
    {
        $cart_items = self::getCartItemsFromCookies();

        foreach ($cart_items as $key => $item) {
            if ($item['slug'] == $slug  && $item['color'] == $color) {
                if ($cart_items[$key]['quantity'] > 1) {
                    $cart_items[$key]['quantity']--;
                    $cart_items[$key]['total_amount'] = round($cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount']);
                }
            }
        }

        self::addCartItemsToCookie($cart_items);
        return $cart_items;
    }

    static public function calculateGrandTotal($items)
    {
        return array_sum(array_column($items, 'total_amount'));
    }
}
