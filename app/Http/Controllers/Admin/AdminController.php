<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    //User Actions

    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('is_approved')) {

            $query->where('is_approved', $request->get('is_approved'));
        }

        return response()->json([
            'users' => $query->get(),
        ], 200);
    }

    public function accept($id)
    {
        $users = User::query()->
        where('id', $id)->where('is_approved', false)->first();
        if (!$users) {
            return response()->json([
                'message' => 'User not found',
            ]);
        }
        $users->is_approved = true;
        $users->save();
        return response()->json([
            'status' => 'success',
            'message' => 'User has been approved successfully',
            'data' => $users
        ]);
    }

    public function reject($id)
    {
        $users = User::query()->find($id);
        if (!$users) {
            return response()->json([
                'message' => 'User not found',
            ]);
        }
        $users->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'User has been rejected successfully',
            'data' => $users
        ]);
    }

}
