<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RestrictIpAddressMiddleware
{
    // Blocked IP addresses
    public $restrictedIp = [
        '92.223.86.20',
        '116.254.124.102',
        '194.5.83.32',
        '116.206.13.90',
        '54.89.52.26',
        //August 23rd 2022, 2:08:32 PM
        '182.253.109.233',
        //August 25th 2022, 4:31:12 AM
        '188.166.189.48',
        /**
         * August 26th 2022, 3:30:25 PM
         * Deleting laporan bhabinkamtibmas NRP 78090781
         */
        '36.72.213.157',
        /**
         * 09/12/2022
         * Penetrating API
         */
        '154.204.45.4'
    ];

    public function handle(Request $request, Closure $next)
    {
        if (in_array($request->ip(), $this->restrictedIp)) {
            Log::alert('IP address ' . $request->ip() . ' is blocked.', [
                'header'    => $request->header(),
                'url'       => $request->url(),
                'request'   => $request->all()
            ]);
            $message = "You are not allowed to access this site. I'm watching you ^•ﻌ•^";
            if ($request->expectsJson()) {
                response()->json([
                    'message' => $message
                ], 403);
            }
            abort(404, $message);
        }
        return $next($request);
    }
}
