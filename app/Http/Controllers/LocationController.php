<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function store(Request $request)
    {
        $coord = $request->validate([
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric']
        ]);

        try {
            $user_id = $request->user()->id;
            $location = Location::updateOrCreate(['user_id' => $user_id], $coord);
            $is_created = $location->created_at == $location->updated_at;

            [$message, $status_code] = array_values(
                match ($is_created) {
                    true => ['Location created successfully', 201],
                    false => ['Location updated successfully', 200]
                }
            );

            return response()->json(['message' => $message], $status_code);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong '.$th->getMessage()
            ], 500);
        }
    }
}
