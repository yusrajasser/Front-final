<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PassengerWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // if role is passenger
        if (auth()->user()->user_role != 'passenger') {
            return abort(401);
        }
        return $next($request);
    }
}
