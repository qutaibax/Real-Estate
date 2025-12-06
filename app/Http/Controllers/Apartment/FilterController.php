<?php

namespace App\Http\Controllers\Apartment;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;

class FilterController extends Controller
{

    public function filter(Request $request)
    {
        $query = Apartment::query();
        $params = $request->validate([
            'city' => 'nullable|string',
            'country' => 'nullable|string',
            'price' => 'nullable',
        ]);
        $apartments = Apartment::query()->filters($params)->get();

        if ($apartments->isEmpty()) {
            return response()->json([
                'message' => 'Not found'
            ], 404);
        }
        return response()->json([
            'message' => 'Success',
            'data' => $apartments,
        ],200);
    }
}
