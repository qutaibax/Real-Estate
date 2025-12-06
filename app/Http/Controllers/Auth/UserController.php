<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

   use Image;
    public function register(Request $request)
    {
        $request->validate(User::rules());
        $request['image']=self::uploadimage($request);
        $request['id_image']=self::uploadimage($request,'id_image');
        $request['password']=Hash::make($request['password']);
        User::query()->create($request->all());
        return response()->json([
            'message' => 'registered successfully,Waiting for Admin to accept',
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'mobile' => 'required|string',
            'password' => 'required',
        ]);

        $user = User::query()->where('mobile', $request->mobile)
            ->first();

        if (!$user || !Hash::check($request['password'], $user->password)) {
            return response()->json(['message' => 'Invalid Credentials']);
        }
        if (!$user['is_approved']) {
            return response()->json([
                'status' => false,
                'message' => 'Be patient ,your account is not approved yet. ',
            ]);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'User logged in successfully.',
            'token' => $token,
        ], 200);


    }
    public function logout(Request $request){
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Logged out successfully.',
        ]);
    }
}
