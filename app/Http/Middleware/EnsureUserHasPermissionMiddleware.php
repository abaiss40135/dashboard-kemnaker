<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasPermissionMiddleware
{
    public function handle(Request $request, Closure $next, $permission)
    {
        abort_if(Gate::denies($permission), Response::HTTP_FORBIDDEN, 'Anda tidak memiliki otoritas untuk akses layanan ini.');
        return $next($request);
    }
}
