<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class CheckIP
{
    public function handle($request, Closure $next)
    {
        if ($request->ip() == '93.183.206.50' || Str::startsWith($request->ip(), ['172.19'])) {
            return $next($request);
        } else {
            return abort(403);
        }
    }
}
