<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class PoldaRequestMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Your logic to determine the user_id
        if (auth()->user()->haveRoleID([
            User::OPERATOR_BHABINKAMTIBMAS_POLDA, User::OPERATOR_BHABINKAMTIBMAS_POLRES, User::BAGOPSNALEV_POLDA, User::BINPOLMAS_POLDA
        ])){
            // Add the user_id to the request data
            $request->merge(['polda' => auth()->user()->personel->polda]);
        }

        return $next($request);
    }
}
