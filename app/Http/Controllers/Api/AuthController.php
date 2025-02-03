<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __invoke(AuthRequest $request){

        $request->validated();

        $user=User::where('email','=', $request->email)->first();
       
        if($user && $user->hasRole($request->role)){
            if(Hash::check($request->password,$user->password)){
              $token=$user->createToken("user")->plainTextToken;
              return successResponse("تم التسجيل الدخول بنجاح",["token"=>$token]);
            }else{
                return failResponse("لا يوجد بيانات  بهذه البانات");                
            }
        }

        return failResponse("لا يوجد بيانات  بهذه البانات");

    }
}
