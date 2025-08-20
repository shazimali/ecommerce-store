<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class DashboardController extends Controller
{


    function account()
    {

        return view('dashboard.account');
    }
    function orders()
    {
        $orders = Order::where('user_id', FacadesAuth::user()->id)->with('detail')->get();
        return view('dashboard.orders', ['orders' => $orders]);
    }
    function reviews()
    {
        return view('dashboard.reviews');
    }
}
