<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class CheckHealthController extends Controller
{
    public function check()
    {
        return response()->json([
            'status' => 'OK',
            'message' => [
                'service' => 'webapp',
                'healthy' => true,
            ]
        ], 200);
    }
}
