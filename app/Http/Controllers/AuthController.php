<?php

namespace App\Http\Controllers;

use App\Mail\SendGmail;
use App\Mail\SendOtpMail;
use App\Models\Departemen;
use App\Models\Karyawan;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    // =========================================================================
    //  KONSTANTA
    // =========================================================================

    /** Masa berlaku OTP login (menit) */
    private const OTP_TTL          = 5;

    /** Masa berlaku OTP registrasi (menit) */
    private const REGISTER_OTP_TTL = 10;

    /** Maksimum percobaan OTP sebelum sesi dibatalkan */
    private const OTP_MAX_ATTEMPTS = 5;

    /** Cooldown resend OTP (detik) */
    private const RESEND_COOLDOWN  = 60;

    // =========================================================================
    //  TAMPIL FORM
    // =========================================================================

    /**
     * Tampilkan form login.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByOtpStatus();
        }

        return view('auth.login');
    }

    /**
     * Tampilkan form registrasi.
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectByOtpStatus();
        }

        if (Departemen::count() === 0) {
            Departemen::create(['nama_departemen' => 'Umum']);
        }

        $departemens = Departemen::all();

        return view('auth.register', compact('departemens'));
    }

    /**
     * Tampilkan form verifikasi OTP (pasca-login).
     */
    public function showOtpVerifyForm()
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        if (Auth::user()->otp_verified_at) {
            return redirect()->route('dashboard');
        }

        if (session('otp_user_id') !== Auth::id()) {
            session(['otp_user_id' => Auth::id()]);
        }

        return view('auth.otp_verify');
    }

    // =========================================================================
    //  LOGIN & LOGOUT
    // =========================================================================

    /**
     * Proses login.
     */
    public function login(Request $request)
    {
        try {
            // BUG 1 FIX: Rate limit dicek PERTAMA, sebelum validate()
            // agar attacker tidak bisa lolos validasi berkali-kali tanpa kena throttle
            $throttleKey = 'login:' . $request->ip();

            if (RateLimiter::tooManyAttempts($throttleKey, 10)) {
                $seconds = RateLimiter::availableIn($throttleKey);
                return back()
                    ->withInput($request->only('email'))
                    ->with('error', "Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik.");
            }

            $credentials = $request->validate([
                'email'    => ['required', 'email'],
                'password' => ['required'],
                'captcha'  => ['required', $this->captchaRule()],
            ]);

            unset($credentials['captcha']);
            $credentials['email'] = strtolower(trim($credentials['email']));

            if (!Auth::attempt($credentials, $request->boolean('remember'))) {
                RateLimiter::hit($throttleKey, 300);
                return back()
                    ->withInput($request->only('email'))
                    ->with('error', 'Email atau password salah.');
            }

            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            try {
                $this->generateAndSendOtp(Auth::user());
            } catch (\Exception $e) {
                // BUG 5 FIX: Invalidate sesi setelah logout agar tidak terjadi session fixation
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->with('error', 'Gagal mengirim OTP. Silakan coba lagi.');
            }

            return redirect()->route('otp.verify.form')
                ->with('success', 'Kode OTP telah dikirim ke email Anda.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Login Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat login.');
        }
    }

    /**
     * Proses logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah logout.');
    }

    // =========================================================================
    //  REGISTRASI
    // =========================================================================

    /**
     * Kirim OTP ke email sebelum submit form registrasi (via AJAX).
     */
    public function sendOtp(Request $request)
    {
        try {
            $email = strtolower(trim($request->input('email', '')));
            $request->merge(['email' => $email]);

            // BUG 1 FIX: Rate limit dicek PERTAMA sebelum validate(),
            // konsisten dengan login() dan verifyOtp()
            $throttleKey = 'register-otp:' . $email;

            if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
                $seconds = RateLimiter::availableIn($throttleKey);
                return response()->json([
                    'success' => false,
                    'message' => "Terlalu banyak permintaan. Coba lagi dalam {$seconds} detik.",
                ], 429);
            }

            RateLimiter::hit($throttleKey, 600);

            $request->validate([
                'email'   => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'captcha' => ['required', $this->captchaRule()],
            ]);

            // FIX: Simpan OTP registrasi di DB (bukan session) agar konsisten & aman
            Otp::where('email', $email)->where('type', 'register')->delete();

            // FIX: Gunakan random_int() yang kriptografis, bukan mt_rand()
            $otp = random_int(100000, 999999);

            $otpRecord = Otp::create([
                'email'      => $email,
                'type'       => 'register',
                'otp'        => Hash::make($otp),
                'expired_at' => now()->addMinutes(self::REGISTER_OTP_TTL),
            ]);

            // BUG 3 FIX: Bungkus mail dalam try-catch dan hapus record jika gagal,
            // sama seperti pola di generateAndSendOtp() agar tidak ada OTP nggantung di DB
            try {
                Mail::to($email)->send(
                    new SendGmail(
                        'Kode Verifikasi Pendaftaran - Punish System',
                        $this->buildOtpEmailBody($otp, self::REGISTER_OTP_TTL)
                    )
                );
            } catch (\Exception $e) {
                $otpRecord->delete();
                throw $e; // re-throw agar ditangkap oleh outer catch
            }

            return response()->json(['success' => true, 'message' => 'OTP berhasil dikirim.']);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Send OTP Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal mengirim OTP.'], 500);
        }
    }

    /**
     * Proses registrasi.
     */
    public function register(Request $request)
    {
        try {
            $email = strtolower(trim($request->input('email', '')));
            $request->merge(['email' => $email]);

            $validated = $request->validate([
                'name'          => ['required', 'string', 'max:255'],
                'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password'      => ['required', 'string', 'min:8', 'confirmed'],
                'departemen_id' => ['required', 'exists:departemens,id'],
                'captcha'       => ['required', $this->captchaRule()],
                // FIX: Validasi OTP dari DB menggunakan Hash::check(), bukan == dari session
                'otp'           => ['required', $this->registerOtpRule($email)],
            ]);

            // Hapus OTP registrasi dari DB setelah berhasil divalidasi (one-time use)
            Otp::where('email', $email)->where('type', 'register')->delete();

            // BUG 3 FIX: Bungkus dalam transaksi DB agar User & Karyawan
            // selalu dibuat bersamaan — jika salah satu gagal, keduanya di-rollback.
            // Tanpa ini, jika Karyawan::create() gagal setelah User::create() berhasil,
            // email tidak bisa dipakai daftar ulang karena unique:users constraint.
            $user = DB::transaction(function () use ($validated) {
                $user = User::create([
                    'name'     => $validated['name'],
                    'email'    => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'role'     => 'user',
                ]);

                Karyawan::create([
                    'nama_karyawan'    => $validated['name'],
                    'email_karyawan'   => $validated['email'],
                    'alamat_karyawan'  => '-',
                    'departemen_id'    => $validated['departemen_id'],
                    'jabatan_karyawan' => 'Staf',
                    'status'           => 'aktif',
                ]);

                return $user;
            });

            Auth::login($user);
            $request->session()->regenerate();

            // FIX: Wrap dalam try-catch — jika OTP gagal dikirim, user tetap terdaftar
            // dan diarahkan ke OTP form dengan pesan error agar bisa resend
            try {
                $this->generateAndSendOtp($user);
            } catch (\Exception $e) {
                return redirect()->route('otp.verify.form')
                    ->with('error', 'Registrasi berhasil, namun OTP gagal dikirim. Gunakan tombol "Kirim Ulang".');
            }

            return redirect()->route('otp.verify.form')
                ->with('success', 'Kode OTP telah dikirim ke email Anda.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Register Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat registrasi.');
        }
    }

    // =========================================================================
    //  OTP VERIFIKASI (PASCA-LOGIN)
    // =========================================================================

    /**
     * Verifikasi OTP login.
     */
    public function verifyOtp(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Sesi tidak valid. Silakan login kembali.');
        }

        // BUG 2 FIX: Rate limit dicek SEBELUM validate()
        // agar attacker tidak bisa brute-force dengan memanfaatkan jeda antara validasi & throttle
        $throttleKey = 'otp-verify:' . $user->id;

        if (RateLimiter::tooManyAttempts($throttleKey, self::OTP_MAX_ATTEMPTS)) {
            // Paksa logout agar tidak bisa brute-force dari sisi session aktif
            Auth::logout();
            $request->session()->invalidate();
            $seconds = RateLimiter::availableIn($throttleKey);
            return redirect()->route('login')
                ->with('error', "Terlalu banyak percobaan OTP. Login ulang dalam {$seconds} detik.");
        }

        $request->merge([
            'otp' => preg_replace('/\D+/', '', (string) $request->input('otp', '')),
        ]);

        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $otpRecord = Otp::where('user_id', $user->id)
            ->where('type', 'login')
            ->latest()
            ->first();

        $isExpired = !$otpRecord || now()->greaterThan($otpRecord->expired_at);

        // FIX: Hash::check() menggantikan == / != yang rentan timing attack & type juggling
        $isValid = !$isExpired && Hash::check($request->input('otp'), $otpRecord->otp);

        if (!$isValid) {
            RateLimiter::hit($throttleKey, 300);
            $message = $isExpired
                ? 'Kode OTP telah kedaluwarsa. Silakan minta kode baru.'
                : 'Kode OTP tidak valid.';
            return back()->with('error', $message);
        }

        // OTP valid: bersihkan record dan tandai user terverifikasi
        RateLimiter::clear($throttleKey);
        $otpRecord->delete();

        /** @var User $user */
        $user->forceFill(['otp_verified_at' => now()])->save();

        $request->session()->forget('otp_user_id');
        $request->session()->regenerate();

        return redirect()->route('dashboard')
            ->with('success', 'Verifikasi berhasil. Selamat datang!');
    }

    /**
     * Kirim ulang OTP login.
     */
    public function resendOtp(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Sesi tidak valid. Silakan login kembali.');
        }

        // Rate limiting resend: maks 1 kali per RESEND_COOLDOWN detik
        $throttleKey = 'otp-resend:' . $user->id;

        if (RateLimiter::tooManyAttempts($throttleKey, 1)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->with('error', "Tunggu {$seconds} detik sebelum meminta kode baru.");
        }

        RateLimiter::hit($throttleKey, self::RESEND_COOLDOWN);

        try {
            $this->generateAndSendOtp($user);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim ulang OTP. Silakan coba lagi.');
        }

        return back()->with('success', 'Kode OTP baru telah dikirim ke email Anda.');
    }

    // =========================================================================
    //  GOOGLE OAUTH
    // =========================================================================

    /**
     * Redirect ke Google OAuth.
     */
    public function googleLogin()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback dari Google OAuth.
     *
     * FIX: Inject Request secara eksplisit — sebelumnya pakai request() global
     *      yang inkonsisten dan tidak testable.
     */
    public function googleCallback(Request $request)
    {
        try {
            // BUG 4 FIX: Hapus ->stateless() karena googleLogin() menggunakan ->redirect()
            // yang stateful (menyimpan OAuth state untuk CSRF protection).
            // Memakai ->stateless()->user() setelah stateful redirect akan menyebabkan
            // "state mismatch" error karena state parameter tidak diverifikasi.
            $googleUser = Socialite::driver('google')->user();
            $email      = strtolower(trim($googleUser->getEmail()));

            $user = User::where('email', $email)->first();

            if (!$user) {
                $departemen = Departemen::first();

                $user = User::create([
                    'name'      => $googleUser->getName(),
                    'email'     => $email,
                    'google_id' => $googleUser->getId(),
                    'avatar'    => $googleUser->getAvatar(),
                    // FIX: 32 karakter lebih aman dari 16
                    'password'  => Hash::make(Str::random(32)),
                    'role'      => 'user',
                ]);

                Karyawan::create([
                    'nama_karyawan'    => $googleUser->getName(),
                    'email_karyawan'   => $email,
                    'alamat_karyawan'  => '-',
                    'departemen_id'    => $departemen?->id ?? 1,
                    'jabatan_karyawan' => 'Staf',
                    'status'           => 'aktif',
                ]);

            } elseif (!$user->google_id) {
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar'    => $googleUser->getAvatar(),
                ]);
            }

            Auth::login($user, true);
            // FIX: Gunakan $request yang diinjeksi, bukan request() global
            $request->session()->regenerate();

            try {
                $this->generateAndSendOtp($user);
            } catch (\Exception $e) {
                // BUG 2 FIX: Invalidate sesi setelah logout agar tidak terjadi session fixation,
                // konsisten dengan penanganan yang sama di login()
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login')
                    ->with('error', 'Login Google berhasil, namun OTP gagal dikirim. Silakan coba lagi.');
            }

            return redirect()->route('otp.verify.form')
                ->with('success', 'Kode OTP telah dikirim ke email Anda.');

        } catch (\Exception $e) {
            Log::error('Google Login Error: ' . $e->getMessage());
            return redirect()->route('login')
                ->with('error', 'Login dengan Google gagal. Silakan coba lagi.');
        }
    }

    // =========================================================================
    //  PRIVATE HELPERS
    // =========================================================================

    /**
     * Generate OTP login, simpan ke DB (hashed), dan kirim via email.
     *
     * FIX 1: Gunakan random_int() bukan mt_rand() (kriptografis aman).
     * FIX 2: Hash OTP sebelum disimpan ke DB menggunakan Hash::make().
     * FIX 3: Jika mail gagal, hapus record OTP dan throw exception
     *        agar caller bisa handle dengan tepat (tidak silent fail).
     *
     * @throws \Exception Jika pengiriman email gagal.
     */
    private function generateAndSendOtp(User $user): void
    {
        // Reset status verifikasi user
        $user->forceFill(['otp_verified_at' => null])->save();

        // Hapus OTP login lama untuk user ini
        Otp::where('user_id', $user->id)->where('type', 'login')->delete();

        // FIX: random_int() kriptografis, bukan mt_rand()
        $otp = random_int(100000, 999999);

        $otpRecord = Otp::create([
            'user_id'    => $user->id,
            'type'       => 'login',
            // FIX: Simpan hash OTP, bukan plaintext
            'otp'        => Hash::make($otp),
            'expired_at' => now()->addMinutes(self::OTP_TTL),
        ]);

        try {
            Mail::to($user->email)->send(new SendOtpMail($otp));
            session(['otp_user_id' => $user->id]);
        } catch (\Exception $e) {
            Log::error('Generate OTP Error [user_id=' . $user->id . ']: ' . $e->getMessage());
            // Hapus record OTP agar tidak menggantung di DB
            $otpRecord->delete();
            throw new \Exception('OTP gagal dikirim.');
        }
    }

    /**
     * Closure rule untuk validasi captcha.
     * Dipindah ke helper agar tidak duplikasi di setiap method validate().
     */
    private function captchaRule(): \Closure
    {
        return function ($attribute, $value, $fail) {
            // Fix 2: Session facade tidak pernah null, berbeda dengan session() helper
            if (!Session::has('captcha')) {
                $fail('Captcha session tidak ditemukan.');
                return;
            }

            // Fix 3: cast ke (string) karena Session::get() mengembalikan mixed
            if (strtolower(trim($value)) !== strtolower(trim((string) Session::get('captcha')))) {
                $fail('Captcha tidak valid.');
            }
        };
    }

    /**
     * Closure rule untuk validasi OTP registrasi dari DB.
     *
     * FIX: Gunakan Hash::check() untuk timing-safe comparison
     *      menggantikan operator == yang rentan type juggling.
     */
    private function registerOtpRule(string $email): \Closure
    {
        return function ($attribute, $value, $fail) use ($email) {
            $record = Otp::where('email', $email)
                ->where('type', 'register')
                ->latest()
                ->first();

            if (!$record) {
                $fail('OTP tidak ditemukan. Silakan minta kode baru.');
                return;
            }

            if (now()->greaterThan($record->expired_at)) {
                $fail('Kode OTP telah kedaluwarsa. Silakan minta kode baru.');
                return;
            }

            // FIX: Hash::check() menggantikan perbandingan == yang tidak aman
            if (!Hash::check($value, $record->otp)) {
                $fail('Kode OTP tidak valid.');
            }
        };
    }

    /**
     * Redirect berdasarkan status OTP user yang sudah login.
     * Menggantikan duplikasi kondisi yang sama di showLogin & showRegister.
     */
    private function redirectByOtpStatus(): \Illuminate\Http\RedirectResponse
    {
        return Auth::user()->otp_verified_at
            ? redirect()->route('dashboard')
            : redirect()->route('otp.verify.form');
    }

    /**
     * Buat isi HTML email OTP.
     * Dipindah ke helper agar tidak duplikasi antara sendOtp dan generateAndSendOtp.
     */
    private function buildOtpEmailBody(int $otp, int $ttlMinutes): string
    {
        return '
            <div style="font-family:sans-serif;max-width:600px;margin:0 auto;padding:20px;
                        border:1px solid #e5e7eb;border-radius:8px;">
                <h2 style="color:#374151;">Kode Verifikasi</h2>
                <p style="color:#4b5563;">Kode OTP Anda adalah:</p>
                <div style="background:#f3f4f6;padding:15px;text-align:center;
                            border-radius:8px;margin:20px 0;">
                    <h1 style="color:#503d42;font-size:36px;letter-spacing:8px;margin:0;">'
                        . $otp .
                    '</h1>
                </div>
                <p style="color:#6b7280;font-size:14px;">
                    Kode ini berlaku selama ' . $ttlMinutes . ' menit.
                    Jangan beritahu kode ini kepada siapapun.
                </p>
            </div>
        ';
    }
}
