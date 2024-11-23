<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class AuthenticateSislapMiddleware
{
    /**
     * @throws AuthenticationException
     */
    public function handle(Request $request, Closure $next)
    {
        $users = ['isikhnas'];
        if (!in_array($request->username, $users) || $request->token !== $this->generateToken($request->username)) {
            throw new AuthenticationException(
                'Unauthenticated.', ['api'], $this->redirectTo($request)
            );
        }
        return $next($request);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    /**
     * @param $nib
     * @return string
     */
    private function generateToken($user): string
    {
        return sha1($user . config('sislap.password') . date('Ymd'));
    }
}
