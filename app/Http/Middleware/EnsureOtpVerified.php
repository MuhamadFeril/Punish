<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureOtpVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return $next($request);
        }

        if ($user->otp_verified_at) {
            return $next($request);
        }

        if (session('otp_user_id') !== $user->id) {
            session(['otp_user_id' => $user->id]);
        }

        if (!$request->routeIs('otp.verify.form', 'otp.verify', 'logout')) {
            return redirect()
                ->route('otp.verify.form')
                ->with('error', 'Selesaikan verifikasi OTP terlebih dahulu.');
        }

        return $next($request);
    }
}
