<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\User;
use App\Notifications\ContactForm;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('site.page.contacts');
    }

    public function contactForm(Request $request)
    {
        /*$rules = ['captcha' => 'required|captcha'];
        $validator = validator()->make(request()->all(), $rules);
        if ($validator->fails()) {
            Session::flash('captcha_error', true);
            return redirect()->back();
        }*/
        $user = new User();
        $user->email = 'cepairda@gmail.com';
        $user->notify(new ContactForm($request->all()));
        //Session::flash('back_call', true);
        return redirect()->back();
    }
}
