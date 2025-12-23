<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\User;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(['is_approved' => 'required|enum']);
        $query = Apartment::query()->with('owner:id,first_name,last_name');
        if ($request->filled('status')) {
            $query->where('status',$request->get('status'));
        }
        $apartments = $query->get();

        return response()->json([
            'data' => $apartments,
        ],200);
    }
    public function accept($id)
    {
        $apartments = Apartment::query()->with('owner')->
        where('id', $id)->where('status', false)->first();
        $apartments->status = true;
        $apartments->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Apartment has been approved successfully',
            'data' => $apartments
        ]);
    }

    public function reject($id)
    {
        $apartments = Apartment::query()->find($id);
        if (!$apartments) {
            return response()->json([
                'message' => 'apartment not found',
            ]);
        }

        $apartments->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Apartment has been rejected successfully',
            'data' => $apartments
        ]);
    }
}
