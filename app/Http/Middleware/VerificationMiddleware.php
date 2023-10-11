<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // Lakukan pengecekan apakah pengguna memiliki bidang 'verification' dengan nilai 'Y'
        if ($user && $user->verification === 'Y') {
            // Jika pengguna terverifikasi, lanjutkan ke rute yang diinginkan
            return $next($request);
        }

        // Jika pengguna tidak terverifikasi, kembalikan tanggapan 'Unauthorized'
        return abort(401, 'Unauthorized');
    }
}
