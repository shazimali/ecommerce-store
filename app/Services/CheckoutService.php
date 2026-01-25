<?php

namespace App\Services;

use App\Events\AdminNotification;
use App\Mail\OrderPlacedEmail;
use App\Mail\UserRegisterEmail;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductColor;
use App\Models\ProductHead;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckoutService
{
    /**
     * Process the checkout: create user (if needed), create order, send emails.
     *
     * @param array $validatedData Form data (email, names, address, etc.)
     * @param array $cartItems
     * @param float $sub_total
     * @param float $total
     * @param float $shipping_charges
     * @param bool $is_shipping_free
     * @param int $coupon_id
     * @param float $coupon_discount
     * @return void
     */
    public function processCheckout($validatedData, $cartItems, $sub_total, $total, $shipping_charges, $is_shipping_free, $coupon_id, $coupon_discount)
    {
        $email = $validatedData['email'];
        $first_name = $validatedData['first_name'];
        $last_name = $validatedData['last_name'];
        $address = $validatedData['address'];
        $phone = $validatedData['phone'];
        $city_id = $validatedData['city_id'];
        $billing_address = $validatedData['resolved_billing_address']; // We will pass resolve value

        // 1. Find or Create User
        $user = User::where('email', $email)->first();

        if (!$user) {
            $password = rand(10, 10000); // Consider using Str::random() or more secure method, but keeping original logic for now
            $user = User::create([
                'email' => $email,
                'name' => $first_name . ' ' . $last_name,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'country' => getLocation()->id,
                'type' => 'CUSTOMER',
                'city_id' => $city_id,
                'phone' => $phone,
                'address' => $address,
                'billing_address' => $billing_address,
                'password' => $password, // Attribute mutator likely hashes this, or should be hashed. Original code passed raw.
            ]);

            // Send Registration Email
            \Illuminate\Support\Facades\Log::info('Dispatching User Register Email...');
            Mail::mailer('noreply')
                ->to($email)
                ->bcc(env('OWNER_EMAIL_ADDRESS'))
                ->send(new UserRegisterEmail($email, $first_name, $password));
            \Illuminate\Support\Facades\Log::info('User Register Email Dispatched');
        }

        // 2. Create Order
        \Illuminate\Support\Facades\Log::info('Creating Order...');
        
        // Optimized Order ID generation
        $lastOrder = Order::latest()->first();
        $nextOrderId = $lastOrder ? $lastOrder->order_id + 1 : 1;

        $order = Order::create([
            'user_id' => $user->id,
            'order_id' => $nextOrderId,
            'order_status' => 'PLACED',
            'sub_total' => $sub_total,
            'total' => $total,
            'shipping_charges' => $shipping_charges,
            'free_shipping' => $is_shipping_free,
            'coupon_id' => $coupon_id,
            'address' => $address,
            'billing_address' => $billing_address,
            'country_id' => getLocation()->id,
            'city_id' => $city_id,
            'phone' => $phone
        ]);
        \Illuminate\Support\Facades\Log::info('Order Created: ' . $order->id);

        // 3. Create Order Details
        foreach ($cartItems as $cart_item) {
            $productColorId = 0;
            // Original logic:
            // ProductColor::where('color_name', $cart_item['color'])->first() ? ... ->id : 0
            if (!empty($cart_item['color'])) {
                $pColor = ProductColor::where('color_name', $cart_item['color'])->first();
                if ($pColor) {
                    $productColorId = $pColor->id;
                }
            }
            
            // Note: Assuming 'slug' always exists and product is found as per original code.
            // Good to add check but refactoring primarily first.
            $product = ProductHead::where('slug', $cart_item['slug'])->first();
            
            OrderDetail::create([
                'order_id' => $order->id,
                'color_id' => $productColorId,
                'product_id' => $product ? $product->id : null, 
                'currency' => $cart_item['currency'],
                'quantity' => $cart_item['quantity'],
                'unit_amount' => round($cart_item['unit_amount']),
                'total_amount' => round($cart_item['total_amount']),
            ]);
        }
        \Illuminate\Support\Facades\Log::info('Order Details Created');

        // 4. Send Order Placed Email
        $email_data['order'] = Order::where('id', $order->id)->first();
        $email_data['order_detail'] = OrderDetail::where('order_id', $order->id)->get();
        $email_data['user_detail'] = $user;
        $email_data['coupon_discount_amount'] = $email_data['order']->sub_total / 100 * $coupon_discount;
        $email_data['coupon_discount'] = $coupon_discount;

        \Illuminate\Support\Facades\Log::info('Dispatching Order Email...');
        Mail::mailer('noreply')
            ->to($email)
            ->bcc(env('OWNER_EMAIL_ADDRESS'))
            ->send(new OrderPlacedEmail($email_data));
        \Illuminate\Support\Facades\Log::info('Order Email Dispatched');

        // 5. Admin Notification
        // event(new AdminNotification('You have a new order ' . 'ED#' . $order->id));
        
        // 6. Clear Cart
        CartManagementService::clearCartItems();
        \Illuminate\Support\Facades\Log::info('Cart Cleared. Checkout Complete.');
    }
}
