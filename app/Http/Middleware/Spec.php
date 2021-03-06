<?php

namespace App\Http\Middleware;

use Closure;

class Spec
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
        if(!$request->user()->isSpec()){
            flash('You are not authorized to do such operation.')->error();
            return redirect('/');
        }
        return $next($request);
    }
}
