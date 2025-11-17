<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekBagian
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$bagians)
    {
        $userLevel = session('level');    
        $userBagian = session('bagian');  

        if ($userLevel === 'admin') {
            return $next($request);
        }

        // Operator hanya boleh akses jika bagian ada di daftar
        if ($userLevel === 'operator' && in_array($userBagian, $bagians)) {
            return $next($request);
        }

        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}
