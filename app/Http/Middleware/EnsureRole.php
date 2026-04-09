<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureRole
{
    /**
     * Handle an incoming request.
     * Usage: ->middleware('role:admin')
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Tidak Dapat Login.'], 401);
        }

        if ($user->role !== $role) {
            return response()->json(['message' => 'Hanya Role Admin Saja.'], 403);
        }

        return $next($request);
    }
}
