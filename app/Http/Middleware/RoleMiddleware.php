<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan masuk terlebih dahulu untuk mengakses halaman ini.');
        }

        $user = Auth::user();

        if (! $user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('error', 'Akun Anda dinonaktifkan oleh administrator.');
        }

        if (! in_array($user->role, $roles, true)) {
            // Redirect to user's appropriate panel or abort 403
            return match ($user->role) {
                'admin' => redirect()->route('admin.dashboard')->with('error', 'Akses dibatasi sesuai hak akses peran Anda.'),
                'perusahaan' => redirect()->route('perusahaan.dashboard')->with('error', 'Akses dibatasi sesuai hak akses peran Anda.'),
                'pelamar' => redirect()->route('pelamar.dashboard')->with('error', 'Akses dibatasi sesuai hak akses peran Anda.'),
                default => abort(403, 'Akses tidak diizinkan.'),
            };
        }

        return $next($request);
    }
}
