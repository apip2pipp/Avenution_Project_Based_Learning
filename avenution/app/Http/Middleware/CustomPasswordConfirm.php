<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CustomPasswordConfirm
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        // 🔥 Kalau user TIDAK punya password → skip confirm
        if ($user && !$user->password) {
            return $next($request);
        }

        // selain itu pakai default behavior
        return app(\Illuminate\Auth\Middleware\RequirePassword::class)
            ->handle($request, $next);
    }
}