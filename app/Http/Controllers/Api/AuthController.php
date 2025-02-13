<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthRequest;
use App\Http\Requests\Api\PasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(AuthRequest $request)
    {
        $request->validated();

        $user = User::where('email', '=', $request->email)->first();

        if (!$user) {
            return failResponse("لا يوجد بيانات");
        }

        if (!Hash::check($request->password, $user->password)) {
            return failResponse("لا يوجد بيانات");
        }

        if ($user->tokens()->count('id') > 0) {
            $user->tokens()->delete();
        }
        
        $token = $user->createToken(name:"user",expiresAt:now()->addDays(2))->plainTextToken;

        return successResponse("تم التسجيل الدخول بنجاح", ["token" => $token, 'role' => $user->roles()->first()->name]);
    }

    public function logout(Request $request)
    {
        $user = $request->user('sanctum');

        $user->currentAccessToken()->delete();

        return successResponse(message: "تم تسجيل الخروج بنجاح");
    }

    public function check(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json([
                'auth' => false,
            ], 200);
        } else {
            return response()->json([
                'auth' => true,
            ], 200);
        }
    }

    public function updatePassword(PasswordRequest $request){
        $request->validated();

        $user=User::where("email",'=',$request->input("email"))->first();

        if(!$user){
            return failResponse(__("auth.failed"));
        }

        $user->update([
            'password'=>$request->input('password'),
        ]);

        return successResponse(message:'تم تحديث كلمة المرور بنجاح');
    }

}
