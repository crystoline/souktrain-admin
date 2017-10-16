<?php

namespace App\Http\Middleware\Api;

use App\User;
use Closure;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //dd($request);
        $request->user->initialize();

        return $next($request);
    }
}
