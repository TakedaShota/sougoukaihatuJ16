<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        if (Auth::user()->is_admin != 1) {
            return redirect('/dashboard')->withErrors([
                'error' => '管理者のみアクセスできます'
            ]);
        }

        return $next($request);
    }
}
