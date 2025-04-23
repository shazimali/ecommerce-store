<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    function login()
    {
        return view('login');
    }

    function register()
    {
        return view('register');
    }
}
