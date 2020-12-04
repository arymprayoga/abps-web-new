<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Myauth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(session()->has('authenticated')) {
            return $next($request);    
        } else {
            // return response('Unauthorized.', 401);
            return redirect()->guest('/');
        }
    }
}
