<?php

namespace App\Services;

use App\Models\ProductHead;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;

class CartManagementService
{

    static public function addCartItems($slug, $color, $is_bundle = false)
    {
        $cart_items = self::getCartItemsFromCookies();

        $existing_items = null;

        foreach ($cart_items as $key => $item) {
            $item_is_bundle = isset($item['is_bundle']) ? $item['is_bundle'] : false;
            if ($item['slug'] == $slug && $item['color'] == $color && $item_is_bundle == $is_bundle) {
                $existing_items = $key;
                break;
            }
        }

        if ($existing_items !== null) {
            $cart_items[$existing_items]['quantity']++;
            $cart_items[$existing_items]['total_amount'] = round($cart_items[$existing_items]['quantity'] * $cart_items[$existing_items]['unit_amount']);
        } else {
            if ($is_bundle) {
                $bundle = \App\Models\Bundle::where('slug', $slug)->with(['price_detail', 'price_detail.country', 'colors'])->first();
                
                if (!$bundle || !$bundle->price_detail) {
                    return count($cart_items);
                }

                $price = $bundle->price_detail->price;
                $today = Carbon::today()->toDateString();
                
                if ($bundle->price_detail->discount > 0 && 
                    $bundle->price_detail->discount_from <= $today && 
                    $bundle->price_detail->discount_to >= $today) {
                    $price = $bundle->price_detail->price - ($bundle->price_detail->price / 100 * $bundle->price_detail->discount);
                }

                $bundleColor = $color ? $bundle->colors->where('color_name', $color)->first() : null;
                $image = $bundleColor ? $bundleColor->image1 : $bundle->image;

                $cart_items[] = [
                    'slug' => $bundle->slug,
                    'color' => $color ?: '',
                    'title' => $bundle->title,
                    'currency' => $bundle->price_detail->country->currency ?? '',
                    'image' => $image,
                    'quantity' => 1,
                    'unit_amount' => $price,
                    'total_amount' => round($price),
                    'is_bundle' => true
                ];
            } else {
                $product = ProductHead::where('slug', $slug)->with(['price_detail', 'price_detail.country', 'colors'])->first();
                
                if (!$product || !$product->price_detail) {
                    return count($cart_items);
                }

                $price = $product->price_detail->price;
                $today = Carbon::today()->toDateString();
                
                if ($product->price_detail->discount > 0 && 
                    $product->price_detail->discount_from <= $today && 
                    $product->price_detail->discount_to >= $today) {
                    $price = $product->price_detail->price - ($product->price_detail->price / 100 * $product->price_detail->discount);
                }

                $productColor = $color ? $product->colors->where('color_name', $color)->first() : null;
                $image = $productColor ? $productColor->image1 : $product->image;

                $cart_items[] = [
                    'slug' => $product->slug,
                    'color' => $color ?: '',
                    'title' => $product->title,
                    'currency' => $product->price_detail->country->currency ?? '',
                    'image' => $image,
                    'quantity' => 1,
                    'unit_amount' => $price,
                    'total_amount' => round($price),
                    'is_bundle' => false
                ];
            }
        }

        self::addCartItemsToCookie(array_values($cart_items));
        return count($cart_items);
    }

    static public function addCartItemsFromProductDetailPage($slug, $color, $qty, $is_bundle = false)
    {
        $cart_items = self::getCartItemsFromCookies();

        $existing_items = null;

        foreach ($cart_items as $key => $item) {
            $item_is_bundle = isset($item['is_bundle']) ? $item['is_bundle'] : false;
            if ($item['slug'] == $slug && $item['color'] == $color && $item_is_bundle == $is_bundle) {
                $existing_items = $key;
                break;
            }
        }

        if ($existing_items !== null) {
            $cart_items[$existing_items]['quantity'] = $cart_items[$existing_items]['quantity'] + $qty;
            $cart_items[$existing_items]['total_amount'] = round($cart_items[$existing_items]['quantity'] * $cart_items[$existing_items]['unit_amount']);
        } else {
            if ($is_bundle) {
                $bundle = \App\Models\Bundle::where('slug', $slug)->with(['price_detail', 'price_detail.country', 'colors'])->first();
                
                if (!$bundle || !$bundle->price_detail) {
                    return count($cart_items);
                }

                $price = $bundle->price_detail->price;
                $today = Carbon::today()->toDateString();

                if ($bundle->price_detail->discount > 0 && 
                    $bundle->price_detail->discount_from <= $today && 
                    $bundle->price_detail->discount_to >= $today) {
                    $price = $bundle->price_detail->price - ($bundle->price_detail->price / 100 * $bundle->price_detail->discount);
                }

                $bundleColor = $color ? $bundle->colors->where('color_name', $color)->first() : null;
                $image = $bundleColor ? $bundleColor->image1 : $bundle->image;

                $cart_items[] = [
                    'slug' => $bundle->slug,
                    'color' => $color ?: '',
                    'title' => $bundle->title,
                    'currency' => $bundle->price_detail->country->currency ?? '',
                    'image' => $image,
                    'quantity' => $qty,
                    'unit_amount' => $price,
                    'total_amount' => round($qty * $price),
                    'is_bundle' => true
                ];
            } else {
                $product = ProductHead::where('slug', $slug)->with(['price_detail', 'price_detail.country', 'colors'])->first();
                
                if (!$product || !$product->price_detail) {
                    return count($cart_items);
                }

                $price = $product->price_detail->price;
                $today = Carbon::today()->toDateString();

                if ($product->price_detail->discount > 0 && 
                    $product->price_detail->discount_from <= $today && 
                    $product->price_detail->discount_to >= $today) {
                    $price = $product->price_detail->price - ($product->price_detail->price / 100 * $product->price_detail->discount);
                }

                $productColor = $color ? $product->colors->where('color_name', $color)->first() : null;
                $image = $productColor ? $productColor->image1 : $product->image;

                $cart_items[] = [
                    'slug' => $product->slug,
                    'color' => $color ?: '',
                    'title' => $product->title,
                    'currency' => $product->price_detail->country->currency ?? '',
                    'image' => $image,
                    'quantity' => $qty,
                    'unit_amount' => $price,
                    'total_amount' => round($qty * $price),
                    'is_bundle' => false
                ];
            }
        }

        self::addCartItemsToCookie(array_values($cart_items));
        return count($cart_items);
    }

    static public function removeCartItem($slug, $color, $is_bundle = false)
    {
        $cart_items = self::getCartItemsFromCookies();

        foreach ($cart_items as $key => $item) {
            $item_is_bundle = isset($item['is_bundle']) ? $item['is_bundle'] : false;
            if ($item['slug'] == $slug && $item['color'] == $color && $item_is_bundle == $is_bundle) {
                unset($cart_items[$key]);
            }
        }

        $cart_items = array_values($cart_items);
        self::addCartItemsToCookie($cart_items);

        return $cart_items;
    }

    static public function addCartItemsToCookie($cart_items)
    {
        Cookie::queue('cart_items', json_encode($cart_items), 60 * 24 * 30);
    }

    static public function getCartItemsFromCookies()
    {
        // 1. Try queued cookies (same request)
        $queued = Cookie::queued('cart_items');
        if ($queued) {
            $cart_items = json_decode($queued->getValue(), true);
            return is_array($cart_items) ? $cart_items : [];
        }

        // Fallback for older versions or different implementations
        foreach (Cookie::getQueuedCookies() as $cookie) {
            if ($cookie->getName() === 'cart_items') {
                $cart_items = json_decode($cookie->getValue(), true);
                return is_array($cart_items) ? $cart_items : [];
            }
        }

        // 2. Fallback to request cookies
        $cart_items = json_decode(Cookie::get('cart_items'), true);

        return is_array($cart_items) ? $cart_items : [];
    }

    static public function clearCartItems()
    {
        Cookie::queue(Cookie::forget('cart_items'));
    }

    static public function incrementQuantityToCartItem($slug, $color, $is_bundle = false)
    {
        $cart_items = self::getCartItemsFromCookies();

        foreach ($cart_items as $key => $item) {
            $item_is_bundle = isset($item['is_bundle']) ? $item['is_bundle'] : false;
            if ($item['slug'] == $slug && $item['color'] == $color && $item_is_bundle == $is_bundle) {
                $cart_items[$key]['quantity'] += 1;
                $cart_items[$key]['total_amount'] = round($cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount']);
            }
        }
        self::addCartItemsToCookie($cart_items);
        return $cart_items;
    }

    static public function decrementQuantityToCartItem($slug, $color, $is_bundle = false)
    {
        $cart_items = self::getCartItemsFromCookies();

        foreach ($cart_items as $key => $item) {
            $item_is_bundle = isset($item['is_bundle']) ? $item['is_bundle'] : false;
            if ($item['slug'] == $slug && $item['color'] == $color && $item_is_bundle == $is_bundle) {
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
