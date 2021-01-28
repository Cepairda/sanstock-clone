<?php

namespace App\Http\Middleware;

use Closure;

class CheckAccess
{
    public function handle($request, Closure $next)
    {
        if (!auth()->user()->accesses->contains($request->route()->getName())) {
            return abort(403);
        }

        return $next($request);
    }
}
