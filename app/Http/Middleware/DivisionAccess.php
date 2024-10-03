<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class DivisionAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $division)
    {
        // Cek apakah user sudah login
        if (Auth::check()) {
            // Cek apakah user adalah admin atau memiliki divisi yang sesuai
            if (Auth::user()->role_id == 1 || Auth::user()->divisions->contains('name', $division)) {
                return $next($request);
            }
        }   

        // Redirect ke halaman dashboard atau tampilkan pesan error
        return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
