<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Banned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->is_banned == true) {
            return redirect('/home')->with('signupError', 'Akun Anda telah diblokir! Silahkan kontak klinik!');
        }

        return $next($request);
    }
}
