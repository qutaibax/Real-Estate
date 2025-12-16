<?php

namespace App\Http\Controllers\Apartment;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;

class BrowseApartmentController extends Controller
{

    //browse the apartments in the home page .
    public function index(Request $request)
    {
        $query = Apartment::query()->with('owner:id,first_name,last_name','images:id,apartment_id,image')
        ->where('status', true);
        $apartments = $query->get();
        return response()->json([
            'data' => $apartments,
        ],200);
    }



}
