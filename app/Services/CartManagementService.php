<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Bundle;
use App\Models\ProductHead;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;

class CartManagementService
{
    public static function addCartItems(string $slug, string $color, bool $is_bundle = false): int
    {
        return self::addCartItemsFromProductDetailPage($slug, $color, 1, $is_bundle);
    }

    public static function addCartItemsFromProductDetailPage(string $slug, string $color, int $qty, bool $is_bundle = false): int
    {
        $cart_items = self::getCartItemsFromCookies();
        $existing_key = null;

        foreach ($cart_items as $key => $item) {
            $item_is_bundle = (bool)($item['is_bundle'] ?? false);
            if ($item['slug'] === $slug && $item['color'] === $color && $item_is_bundle === $is_bundle) {
                $existing_key = $key;
                break;
            }
        }

        if ($existing_key !== null) {
            $cart_items[$existing_key]['quantity'] += $qty;
            $cart_items[$existing_key]['total_amount'] = (int) round($cart_items[$existing_key]['quantity'] * $cart_items[$existing_key]['unit_amount']);
        } else {
            if ($is_bundle) {
                $bundle = Bundle::where('slug', $slug)->with(['price_detail', 'price_detail.country', 'colors'])->first();

                if (!$bundle || !$bundle->price_detail) {
                    return count($cart_items);
                }

                $price = (float) $bundle->price_detail->price;
                $today = Carbon::today()->toDateString();

                if (
                    $bundle->price_detail->discount > 0 &&
                    $bundle->price_detail->discount_from <= $today &&
                    $bundle->price_detail->discount_to >= $today
                ) {
                    $price -= ($price / 100 * $bundle->price_detail->discount);
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
                    'total_amount' => (int) round($qty * $price),
                    'is_bundle' => true
                ];
            } else {
                $product = ProductHead::where('slug', $slug)->with(['price_detail', 'price_detail.country', 'colors'])->first();

                if (!$product || !$product->price_detail) {
                    return count($cart_items);
                }

                $price = (float) $product->price_detail->price;
                $today = Carbon::today()->toDateString();

                if (
                    $product->price_detail->discount > 0 &&
                    $product->price_detail->discount_from <= $today &&
                    $product->price_detail->discount_to >= $today
                ) {
                    $price -= ($price / 100 * $product->price_detail->discount);
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
                    'total_amount' => (int) round($qty * $price),
                    'is_bundle' => false
                ];
            }
        }

        self::addCartItemsToCookie(array_values($cart_items));
        return count($cart_items);
    }

    public static function removeCartItem(string $slug, string $color, bool $is_bundle = false): array
    {
        $cart_items = self::getCartItemsFromCookies();

        foreach ($cart_items as $key => $item) {
            $item_is_bundle = (bool)($item['is_bundle'] ?? false);
            if ($item['slug'] === $slug && $item['color'] === $color && $item_is_bundle === $is_bundle) {
                unset($cart_items[$key]);
            }
        }

        $cart_items = array_values($cart_items);
        self::addCartItemsToCookie($cart_items);

        return $cart_items;
    }

    public static function addCartItemsToCookie(array $cart_items): void
    {
        Cookie::queue('cart_items', json_encode($cart_items), 60 * 24 * 30);
    }

    public static function getCartItemsFromCookies(): array
    {
        $queued = Cookie::queued('cart_items');
        if ($queued) {
            $cart_items = json_decode((string) $queued->getValue(), true);
            return is_array($cart_items) ? $cart_items : [];
        }

        foreach (Cookie::getQueuedCookies() as $cookie) {
            if ($cookie->getName() === 'cart_items') {
                $cart_items = json_decode((string) $cookie->getValue(), true);
                return is_array($cart_items) ? $cart_items : [];
            }
        }

        $cookieVal = Cookie::get('cart_items');
        $cart_items = is_string($cookieVal) ? json_decode($cookieVal, true) : [];

        return is_array($cart_items) ? $cart_items : [];
    }

    public static function clearCartItems(): void
    {
        Cookie::queue(Cookie::forget('cart_items'));
    }

    public static function incrementQuantityToCartItem(string $slug, string $color, bool $is_bundle = false): array
    {
        $cart_items = self::getCartItemsFromCookies();

        foreach ($cart_items as $key => $item) {
            $item_is_bundle = (bool)($item['is_bundle'] ?? false);
            if ($item['slug'] === $slug && $item['color'] === $color && $item_is_bundle === $is_bundle) {
                $cart_items[$key]['quantity'] += 1;
                $cart_items[$key]['total_amount'] = (int) round($cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount']);
            }
        }
        self::addCartItemsToCookie($cart_items);
        return $cart_items;
    }

    public static function decrementQuantityToCartItem(string $slug, string $color, bool $is_bundle = false): array
    {
        $cart_items = self::getCartItemsFromCookies();

        foreach ($cart_items as $key => $item) {
            $item_is_bundle = (bool)($item['is_bundle'] ?? false);
            if ($item['slug'] === $slug && $item['color'] === $color && $item_is_bundle === $is_bundle) {
                if ($cart_items[$key]['quantity'] > 1) {
                    $cart_items[$key]['quantity']--;
                    $cart_items[$key]['total_amount'] = (int) round($cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount']);
                }
            }
        }

        self::addCartItemsToCookie($cart_items);
        return $cart_items;
    }

    public static function calculateGrandTotal(array $items): float
    {
        return (float) array_sum(array_column($items, 'total_amount'));
    }
}

