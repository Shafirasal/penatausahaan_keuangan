<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekLevel
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$levels)
    {
        $userLevel = session('level');

        if (!in_array($userLevel, $levels)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
