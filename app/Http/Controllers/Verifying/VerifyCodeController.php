<?php

namespace App\Http\Controllers\Verifying;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class VerifyCodeController extends Controller
{
   public function verify(Request $request,User $user){
       $request->validate([
           'code'=>'required|digits:4',
       ]);
       if($user->verification_code==$request->code){
           $user->update(['verification_code'=>null]);
           return response()->json([
               'success'=>true,
               'message'=>'the code is correct,verified successfully',
           ]);
       }else
           return response()->json([
               'success'=>false,
               'message'=>'the code is invalid,please try again',
           ]);
   }
}
