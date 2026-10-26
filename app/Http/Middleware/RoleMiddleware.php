<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Role mapping & hierarchy:
        // owner has full administrative power.
        // pelanggan matches pembeli.
        $roleAliases = [
            'owner' => ['owner', 'admin'],
            'admin' => ['owner', 'admin'],
            'staff' => ['owner', 'admin', 'staff'],
            'pelanggan' => ['pelanggan', 'pembeli'],
            'pembeli' => ['pelanggan', 'pembeli'],
        ];

        $hasRole = false;
        if ($user->role === 'owner') {
            $hasRole = true;
        } elseif (in_array($user->role, $roles)) {
            $hasRole = true;
        } else {
            foreach ($roles as $r) {
                if (isset($roleAliases[$r]) && in_array($user->role, $roleAliases[$r])) {
                    $hasRole = true;
                    break;
                }
            }
        }

        if (!$hasRole) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
