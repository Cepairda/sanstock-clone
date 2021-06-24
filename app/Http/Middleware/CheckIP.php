<?php

namespace App\Http\Middleware;

use Closure;
use Cookie;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CheckIP
{
    public function handle(Request $request, Closure $next)
    {
        session()->keep(['order']);
        if($request->get('access') == 'true') {
            Cookie::queue('access', 'true', 60 * 24);
        }

        if (
            $request->ip() == '93.183.206.50'
            || Str::startsWith($request->ip(), ['172.19', '127.0.0.1'])
            || $request->cookie('access')
            || true
        ) {

            return $next($request);
        } else {
            return abort(403);
        }
    }
}
