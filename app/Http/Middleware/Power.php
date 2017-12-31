<?php

namespace App\Http\Middleware;

use Closure;

class Power
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
        if(!$request->user()->isPower()){
            flash('You are not authorized to do such operation.')->error();
            return redirect('/');
        }
        return $next($request);
    }
}
