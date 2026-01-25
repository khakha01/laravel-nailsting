<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JwtFromCookie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie('admin_token');

        if ($token) {
            $request->headers->set('Authorization', 'Bearer ' . $token);
            
            try {
                // Force JWTAuth to parse and authenticate the token
                if ($user = \PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth::setToken($token)->authenticate()) {
                    \Auth::guard('admin')->setUser($user);
                    \Auth::shouldUse('admin');
                }
            } catch (\Exception $e) {
                // In case of any error with the token, we clear it
                return $next($request)->withoutCookie('admin_token');
            }
        }

        return $next($request);
    }
}
