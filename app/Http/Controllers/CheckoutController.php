<?php

namespace App\Http\Controllers;

use App\Services\CartManagementService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('checkout');
    }
}
