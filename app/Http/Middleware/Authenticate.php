<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('auth.login')->with("error", "You must be logged in to access this page.");
        }

        if (auth()->check() && auth()->user()->is_active === 0 && (auth()->user()->role === 'admin' || auth()->user()->role === 'user')) {
            auth()->logout();
            session()->flush();
            return redirect()->route('auth.login')->with("error", "Your account is inactive. Please contact the administrator.");
        }

        if (auth()->check() && auth()->user()->role === 'admin' || auth()->user()->role === 'user')
        {
            $expiresAt = session('session_expires_at');

            if ($expiresAt && now()->isAfter($expiresAt)) {
                // Session expired - logout user
                auth()->user()->update(["is_active" => 0]);
                auth()->logout();
                session()->flush();
                return redirect('/')->with('message', 'Session anda telah berakhir. Silakan minta akses kembali ke Super Admin.');
            }
        }

        return $next($request);
    }
}
