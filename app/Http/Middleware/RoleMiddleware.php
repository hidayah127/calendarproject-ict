<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userRole = auth()->user()->role;

        // if (auth()->user()->role !== $role) {
        //     abort(403, 'Unauthorized. You do not have access to this area.');
        // }

        // Allow multiple roles
        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized. You do not have access to this area.');
        }

        return $next($request);
    }
}