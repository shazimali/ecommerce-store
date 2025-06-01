<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactUsRequest;
use App\Mail\ContactUsEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    public function index()
    {
        return view('contact_us');
    }

    public function sendEmail(ContactUsRequest $request)
    {
        // $path = '';
        // if($request->hasFile('attachment')){
        //     $fileName = time() . '.' . $request->attachment->extension();
        //     $path = $request->file('attachment')->storeAs('uploads', $fileName, 'public');
        //     Mail::mailer('contactus')->to(env('CONTACT_US_MAIL_USERNAME'))->send(new ContactUsEmail($request->all(), $path));
        // }else{
            // Mail::mailer('contactus')->to(env('CONTACT_US_MAIL_USERNAME'))->send(new ContactUsEmail($request->all(), $path));
            Mail::mailer('contactus')->to(env('CONTACT_US_MAIL_USERNAME'))->send(new ContactUsEmail($request->all()));
        // }
        return back()->with('success', 'Your request has been sent.');
    }
}
