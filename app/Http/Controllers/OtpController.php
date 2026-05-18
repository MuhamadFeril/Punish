<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Otp;
use App\Models\User;

class OtpController extends Controller
{
    public function showVerifyForm()
    {
        if (Auth::check() && Auth::user()->otp_verified_at) {
            return redirect()->route('dashboard');
        }

        if (!session('otp_user_id')) {
            if (Auth::check()) {
                session(['otp_user_id' => Auth::id()]);
            } else {
                return redirect()->route('login');
            }
        }

        return view('auth.otp_verify');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $userId = session('otp_user_id');
        if (!$userId) {
            return redirect()->route('login')->with('error', 'Session OTP tidak ditemukan. Silakan login ulang.');
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('login')->with('error', 'User tidak ditemukan. Silakan login ulang.');
        }

        $otp = Otp::where('user_id', $userId)
            ->where('otp', $request->otp)
            ->where('is_used', false)
            ->where('expired_at', '>', now())
            ->latest()
            ->first();

        if (!$otp) {
            return back()->with('error', 'Kode OTP salah atau sudah kedaluwarsa.');
        }

        $otp->forceFill([
            'is_used' => true,
        ])->save();

        Otp::where('user_id', $userId)
            ->where('id', '!=', $otp->id)
            ->delete();

        $user->forceFill([
            'otp_verified_at' => now(),
        ])->save();

        if (!Auth::check() || Auth::id() !== $user->id) {
            Auth::login($user, true);
        }

        $request->session()->forget('otp_user_id');
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', 'Verifikasi OTP berhasil!');
    }
}
