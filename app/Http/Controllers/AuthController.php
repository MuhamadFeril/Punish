<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use App\Mail\SendGmail;
class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect('dashboard');
        }
        return view('auth.login');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
                'captcha' => ['required', function ($attribute, $value, $fail) {
                    Log::info("Login Captcha: expected '" . session('captcha') . "', got '" . $value . "'");
                    if (strtolower(trim($value)) !== strtolower(trim(session('captcha')))) {
                        $fail('Captcha tidak valid.');
                    }
                }],
            ]);

            unset($credentials['captcha']);

            if (Auth::attempt($credentials, $request->boolean('remember'))) {
                $request->session()->regenerate();
                $redirectTo = $this->redirectToDashboard();

                return redirect()->intended($redirectTo)->with('success', 'Selamat datang!');
            }

            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Email atau password salah.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    private function redirectToDashboard(): string
    {
        return route('dashboard');
    }

    /**
     * Show register form
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect('dashboard');
        }

        if (Departemen::count() === 0) {
            Departemen::create(['nama_departemen' => 'Umum']);
        }

        $departemens = Departemen::all();
        return view('auth.register', compact('departemens'));
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'departemen_id' => ['required', 'exists:departemens,id'],
                'captcha' => ['required', function ($attribute, $value, $fail) {
                    Log::info("Register Captcha: expected '" . session('captcha') . "', got '" . $value . "'");
                    if (strtolower(trim($value)) !== strtolower(trim(session('captcha')))) {
                        $fail('Captcha tidak valid.');
                    }
                }],
                'otp' => ['required', function ($attribute, $value, $fail) use ($request) {
                    if ($value != session('register_otp') || $request->email !== session('register_otp_email')) {
                        $fail('Kode OTP tidak valid atau email tidak cocok.');
                    }
                    if (now()->greaterThan(session('register_otp_expires'))) {
                        $fail('Kode OTP telah kedaluwarsa. Silakan minta kode baru.');
                    }
                }],
            ]);

            // Bersihkan session OTP
            session()->forget(['register_otp', 'register_otp_email', 'register_otp_expires']);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role' => 'user',
            ]);

            Karyawan::create([
                'nama_karyawan' => $validated['name'],
                'email_karyawan' => $validated['email'],
                'alamat_karyawan' => '-',
                'departemen_id' => $validated['departemen_id'],
                'jabatan_karyawan' => 'Staf',
                'status' => 'aktif',
            ]);

            Auth::login($user);
            return redirect('dashboard')->with('success', 'Registrasi berhasil!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    /**
     * Handle sending OTP for registration
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'captcha' => ['required', function ($attribute, $value, $fail) {
                if (strtolower(trim($value)) !== strtolower(trim(session('captcha')))) {
                    $fail('Captcha tidak valid.');
                }
            }],
        ]);

        $otp = mt_rand(100000, 999999);
        
        session([
            'register_otp' => $otp,
            'register_otp_email' => $request->email,
            'register_otp_expires' => now()->addMinutes(10)
        ]);

        $bodyContent = '
            <div style="font-family: sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e5e7eb; border-radius: 8px;">
                <h2 style="color: #374151;">Kode Verifikasi Pendaftaran</h2>
                <p style="color: #4b5563;">Terima kasih telah mendaftar. Kode OTP Anda adalah:</p>
                <div style="background: #f3f4f6; padding: 15px; text-align: center; border-radius: 8px; margin: 20px 0;">
                    <h1 style="color: #503d42; font-size: 36px; letter-spacing: 8px; margin: 0;">' . $otp . '</h1>
                </div>
                <p style="color: #6b7280; font-size: 14px;">Kode ini berlaku selama 10 menit. Jangan beritahu kode ini kepada siapapun.</p>
            </div>
        ';

        try {
            Mail::to($request->email)->send(new SendGmail('Kode Verifikasi Pendaftaran - Punish System', $bodyContent));
            return response()->json(['success' => true, 'message' => 'OTP berhasil dikirim ke email Anda']);
        } catch (\Exception $e) {
            Log::error('Gagal mengirim OTP: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal mengirim email OTP. Silakan coba lagi.'], 500);
        }
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Anda telah logout');
    }

    /**
     * Redirect to Google OAuth
     */
    public function googleLogin()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function googleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Find or create user
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Create new user from Google data
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => Hash::make(uniqid()), // Random password for OAuth users
                    'role' => 'user',
                ]);

                // Create corresponding karyawan record
                Karyawan::create([
                    'nama_karyawan' => $googleUser->getName(),
                    'email_karyawan' => $googleUser->getEmail(),
                    'alamat_karyawan' => '-',
                    'departemen_id' => Departemen::first()->id ?? 1,
                    'jabatan_karyawan' => 'Staf',
                    'status' => 'aktif',
                ]);
            } else {
                // Update existing user with Google info if not already set
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->getId(),
                        'avatar' => $googleUser->getAvatar(),
                    ]);
                }
            }

            // Login the user
            Auth::login($user, remember: true);

            return redirect()->intended(route('dashboard'))
                ->with('success', 'Selamat datang! Login dengan Google berhasil.');

        } catch (\Exception $e) {
            Log::error('Google login error: ' . $e->getMessage());
            return redirect()->route('login')
                ->with('error', 'Google login gagal: ' . $e->getMessage());
        }
    }
}
