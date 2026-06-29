<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Detection\MobileDetect;

class DetectMobileDevice
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $detect = new MobileDetect;

        // Use isMobile() for broad detection OR isTablet() — treat tablets as mobile too
        $isMobile = $detect->isMobile() || $detect->isTablet();

        if (auth()->check() && $isMobile) {
            // Only redirect if not already on a mobile, API, logout, or OTP route
            if (!$request->is('mobile') &&
                !$request->is('mobile/*') &&
                !$request->is('logout') &&
                !$request->is('otp/*') &&
                !$request->is('api/*')) {
                return redirect()->route('mobile.vue');
            }
        }

        return $next($request);
    }
}
