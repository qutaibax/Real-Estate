<?php

namespace App\Http\Controllers\Apartment;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;

class AddApartmentController extends Controller
{
    public function add(Request $request)
    {
        $validate = $request->validate(Apartment::rules());

        $apartment = Apartment::query()->create($validate);
        return response()->json([
            'message' => 'Successfully created apartment,Wait for the admin to accept',
        ]);

    }

}
