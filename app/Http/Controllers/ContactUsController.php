<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Mail\contactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    public function index()
    {
        return view('contact_us');
    }

    public function sendEmail(ContactRequest $request)
    {
        $adminEmail = "abidranaabid90@gmail.com";

        $fileName = time() . '.' . $request->attachment->extension();
        $path = $request->file('attachment')->storeAs('uploads', $fileName, 'public');


        $response = Mail::to($adminEmail)->send(new contactMail($request->all(), $path));
        dd($response);
    }
}
