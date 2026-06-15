<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();
        if (!$user) {
            abort(403, 'Unauthorized action.');
        }

        $normalizedRole = str_replace('_', '-', $role);

        if (!$user->role || $user->role->slug !== $normalizedRole) {
            abort(403, 'Unauthorized action.');
        }

        if ($user->status !== 'approved' && $user->status !== 'active') {
            abort(403, 'Your account is pending admin approval.');
        }

        return $next($request);
    }
}
