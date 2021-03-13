<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HasRoles
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = \Auth::user();
        $user->load('roles');

        if ($user->roles->isEmpty()) {
            abort(404);
        }

        return $next($request);
    }
}
