<?php

namespace App\Http\Controllers;

use App\Mail\OrderPlacedEmail;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Services\CartManagementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = CartManagementService::getCartItemsFromCookies();
        if (count($cartItems)) {
            return view('checkout');
        }
        return redirect()->route('home');
    }

    public function orderDetail($order_id)
    {
        $order = Order::where('order_id', $order_id)->first();
        if ($order) {
            return view('order_detail', ['order' => $order]);
        } else {
            abort('404');
        }
    }
}
