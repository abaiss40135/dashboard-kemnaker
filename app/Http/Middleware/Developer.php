<?php

namespace App\Http\Middleware;

use Closure;

class Developer
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
        if(!auth()->check() || !in_array($request->user()->email, [
            'aditya@brainmatics.com', 'karno@brainmatics.com', 'julianto@brainmatics.com', 'aziz@brainmatics.com'
        ])){
            abort(403);
        }
        return $next($request);
    }
}
