<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin
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
        if (!auth()->check() || auth()->user()->user_role_id != 1) {
            return redirect('/home')->with('signupError', 'Hanya admin yang bisa mengaksesnya!');
        }

        return $next($request);
    }
}
