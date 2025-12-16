<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\Image;
use App\Traits\sendWhatsAppMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    use Image, sendWhatsAppMessage;

    public function register(Request $request)
    {
        $request->validate(User::rules());
        $data = $request->except('image', 'id_image');

        if ($path = self::uploadimage($request)) {
            $data['image'] = $path;
        }
        if ($path2 = self::uploadimage($request, 'id_image')) {
            $data['id_image'] = $path2;
        }
        $data['password'] = Hash::make($request['password']);

        $user = User::query()->create($data);

        $code = str_pad(rand(0, 999), 4, '0', STR_PAD_LEFT);
        $user['verification_code'] = $code;
        $user->save();

        self::send($data['mobile'], $code);
        return response()->json([
            'message' => 'registered successfully,Waiting for Admin to accept',
            'id_user'=>$user['id'],
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

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Logged out successfully.',
        ]);
    }


}
