<?php

namespace App\Http\Controllers;

use App\Http\Requests\contactFormRequest;
use App\Mail\ContactForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function action(contactFormRequest $request){
        // Send message to admin
        Mail::to(config('tripsitta.admin_email'))->send(new ContactForm($request->validated()));

        return redirect()->back()->with('message', 'Email sent successfully. We\'ll contact you as soon as possible');
    }
}
