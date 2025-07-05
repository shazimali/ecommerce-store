<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function index()
    {
        return view('dashboard');
    }

    function account()
    {
        return view('dashboard.account');
    }
    function orders()
    {
        return view('dashboard.orders');
    }
    function reviews()
    {
        return view('dashboard.reviews');
    }
}
