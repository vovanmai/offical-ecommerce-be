<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SetGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[] $guard
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, $guard)
    {
        Auth::shouldUse($guard);
        return $next($request);
    }
}
