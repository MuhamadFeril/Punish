<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Session;

class CaptchaController extends Controller
{
    public function generateCaptcha()
    {
        $builder = new CaptchaBuilder;
        $builder->build();
        $phrase = $builder->getPhrase();

        Session::put('captcha', $phrase);

        return response()->json([
            'success' => true,
            'captcha_image' => $builder->inline(),
        ]);
    }

    public function validateCaptcha(Request $request)
    {
        $request->validate([
            'captcha' => 'required',
        ]);

        $phrase = Session::get('captcha');

        if ($request->captcha == $phrase) {
            return response()->json([
                'success' => true,
                'message' => 'Captcha valid!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Captcha tidak valid!'
        ], 400);
    }
}
