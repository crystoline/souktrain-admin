<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminOnlyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
    	if(!Auth::guard($guard)->check() or !Auth::user()->hasPermission('view_admin_dashboard') ){

		    if ($request->ajax()) {
			    return response( 'Unauthorized.', 401 );
		    }

			    return redirect()->route('admin.logout');
	    }
        return $next($request);
    }
}
