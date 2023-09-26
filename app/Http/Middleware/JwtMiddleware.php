<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Route;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
         // Check if the current route is 'login' or 'register'
         if ($request->routeIs('login','register') || route::has('logout','refresh')) {
            // Allow the request to proceed without JWT verification
            return $next($request);
        }

    try {
        $token = JWTAuth::parseToken()->authenticate();
    } catch (\Exception $e) {
        return response()->json(['message' => 'Unauthorized.'], 401);
    }

    if (!$token) {
        return response()->json(['message' => 'Unauthorized.'], 401);
    }

    return $next($request);
}
}
