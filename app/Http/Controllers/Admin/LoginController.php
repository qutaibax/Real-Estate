<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function adminLogin(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required',
        ]);

        $admin = Admin::query()->where('name', $request->name)
            ->first();
        if (!$admin || !Hash::check($request['password'], $admin->password)) {
            return response()->json(['message' => 'Invalid Credentials'],404);
        }
        return response()->json([
            'message' => 'Admin logged in successfully.',

        ], 200);


    }
}
