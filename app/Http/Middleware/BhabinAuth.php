<?php

namespace App\Http\Middleware;

use Closure;

class BhabinAuth
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
        if(!role('bhabinkamtibmas')){
            return redirect()->back();
            die;
        }
        return $next($request);
    }
}
