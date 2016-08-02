<?php

namespace MauroMoreno\LaravelTheme\Middleware;

use Closure;
use MauroMoreno\LaravelTheme\Facades\Theme;

class SetTheme
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $themeName
     * @return mixed
     */
    public function handle($request, Closure $next, $themeName)
    {
        Theme::set($themeName);
        return $next($request);
    }
}
