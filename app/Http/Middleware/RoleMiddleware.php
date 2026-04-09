<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  $role
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect('login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Check if user has the required role
        if (Auth::user()->role !== $role) {
            return redirect('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini (Diperlukan: ' . $role . ')');
        }

        return $next($request);
    }
}
