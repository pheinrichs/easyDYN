<?php

namespace App\Http\Middleware;

use Closure;

class CheckCpanelVars
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
        if(env('CPANEL_USER') == null || env('CPANEL_PASS') == null || env('CPANEL_URL') == null|| env('CPANEL_DOMAIN') == null) {
            return redirect('error')->with('status','Some of your cPanel variables are not set. Please configure them to continue');
        }
        else {
            return $next($request);
        }

    }
}
