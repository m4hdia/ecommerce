<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $allowedRoles = ! empty($roles) ? $roles : ['admin'];

        if (! in_array($request->user()->role, $allowedRoles, true)) {
            abort(403, 'This action is unauthorized.');
        }

        return $next($request);
    }
}




