<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Session;

class CaptchaController extends Controller
{
    public function showForm()
    {
        return view('captcha');
    }

    public function generateCaptcha()
    {
        $builder = new CaptchaBuilder;
        $builder->build();
        $phrase = $builder->getPhrase();

        Session::put('captcha', $phrase);
        Session::save();
        return response($builder->get())
            ->header('Content-Type', 'image/jpeg')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }

    public function validateCaptcha(Request $request)
    {
        $request->validate([
            'captcha' => 'required',
        ]);

        $phrase = Session::get('captcha');

        if ($request->captcha == $phrase) {
            return redirect()->back()->with('success', 'Captcha valid!');
        }

        return redirect()->back()->with('error', 'Captcha tidak valid!');
    }
    public function verify(Request $request)
    {
        $request->validate([
            'captcha' => 'required',
        ]);

        $phrase = Session::get('captcha');

        if ($request->captcha == $phrase) {
            return redirect()->back()->with('success', 'Captcha valid!');
        }

        return redirect()->back()->with('error', 'Captcha tidak valid!');
    }   
    
    public function refreshCaptcha(Request $request)
    {
        $builder = new CaptchaBuilder;
        $builder->build();
        $phrase = $builder->getPhrase();

        Session::put('captcha', $phrase);
        Session::save();
        return response($builder->get())
            ->header('Content-Type', 'image/jpeg')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }
}