<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(AuthRequest $request)
    {

        $request->validated();

        $user = User::where('email', '=', $request->email)->first();

        if (Hash::check($request->password, $user->password)) {
        
            if($user->tokens()->count('id') > 0){
                $user->tokens()->delete();
            }
        
            $token = $user->createToken("user")->plainTextToken;
        
            return successResponse("تم التسجيل الدخول بنجاح", ["token" => $token,'role'=>$user->roles()->first()->name]);
        
        }


        return failResponse("لا يوجد بيانات  بهذه البانات");

    }

    public function logout(Request $request)
    {

        $user = $request->user('sanctum');

        $user->currentAccessToken()->delete();

        return successResponse(message: "تم تسجيل الخروج بنجاح");
    }

}
