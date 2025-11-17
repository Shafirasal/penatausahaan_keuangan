<?php

// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Http\Request;

// class CekBagian
// {
//     /**
//      * Handle an incoming request.
//      */
// // app/Http/Middleware/CekBagian.php
// public function handle(Request $request, Closure $next, ...$bagians)
// {
//     if (!auth()->check()) {
//         return redirect()->route('login');
//     }

//     $user = auth()->user();
//     $userLevel = $user->level;    
//     $userBagian = $user->bagian;  

//     if ($userLevel === 'admin') {
//         return $next($request);
//     }

//     if ($userLevel === 'operator' && in_array($userBagian, $bagians)) {
//         return $next($request);
//     }

//     abort(403, 'Anda tidak memiliki akses ke halaman ini.');
// }
// }


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekBagian
{
    public function handle(Request $request, Closure $next, ...$bagians)
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // Admin bisa akses semua
        if ($user->level === 'admin') {
            return $next($request);
        }

        // Operator hanya bisa akses bagiannya
        if ($user->level === 'operator' && in_array($user->bagian, $bagians)) {
            return $next($request);
        }

        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}