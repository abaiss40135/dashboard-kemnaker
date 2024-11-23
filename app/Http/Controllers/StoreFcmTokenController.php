<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StoreFcmTokenController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = auth()->user()->update([
            'fcm_key' => $request->fcm_token
        ]);

        return response()->json(['token stored successfully.']);
    }
}
