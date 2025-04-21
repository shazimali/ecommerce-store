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

        $order =  Order::where('id', 15)->first();
        $email_data['order'] = $order;
        $email_data['order_detail'] = OrderDetail::where('order_id', $order->id)->with('product')->get();
        // Mail::to('hamza.khalid44444@gmail.com')->send(new OrderPlacedEmail($email_data));
        // return view('email.order-placed', ['email_data' => $email_data]);
        return view('checkout');
    }
}
