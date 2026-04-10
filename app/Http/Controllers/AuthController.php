<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            ]);

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
        if (Auth::check() && Auth::user()->isAdmin()) {
            return route('dashboard');
        }

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
            ]);

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
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Anda telah logout');
    }
}
