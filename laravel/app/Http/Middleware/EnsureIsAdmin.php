<?php

// app/Http/Middleware/EnsureIsAdmin.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureIsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->status !== 'admin') {
            // opsi A: tolak dengan 403
            abort(403, 'Tidak punya akses.');

            // opsi B: redirect ke beranda + pesan
            // return redirect('/login')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }

        return $next($request);
    }
}
