<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class ContactUsController extends Controller
{
    public function send(Request $request)
    {
        $data = $request->validate([
            'name' => ['required'],
            'email' => ['required'],
            'message' => ['required'],
        ]);

        Mail::to('admin@email.com')->send(new ContactMail($data));

        return back()->with('success', 'Message was successfully send!');
        // return response()->json(['success' => 'Email sent successfully.']);
    }
}
