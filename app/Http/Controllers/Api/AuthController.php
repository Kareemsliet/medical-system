<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthRequest;
use App\Http\Services\UserService;
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
                "email_verified"=>auth("sanctum")->user()->hasVerifiedEmail(),
                "status"=>auth("sanctum")->user()->getStatus(),
            ], 200);
        }
    }

    public function updatePassword(Request $request){

        $validation=validator()->make($request->only(['password_confirmation',"password"]),[
            "password"=>"required|min:8|string|confirmed",
        ]);

        if($validation->fails()){
            return failResponse($validation->errors()->first());
        }

        $user=$request->user();

        $user->update([
            'password'=>Hash::make($request->input('password')),
        ]);

        return successResponse(message:'تم تحديث كلمة المرور بنجاح');
    }

    public function sendEmailVerification(Request $request){
        $user=$request->user();

        (new UserService())->sendEmailVerification($user);

        return successResponse(message:'تم ارسال الكود الي بريدك الاكتروني بنجاح');
    }

    public function verifyEmail(Request $request){
        
        $validation=validator()->make($request->only(['code']),[
            "code"=>"required|exists:users,email_verified_code|string",
        ]);

        if($validation->fails()){
            return failResponse($validation->errors()->first());
        }

        $validation->validated();

        $user=User::where('email_verified_code','=',$request->input("code"))->whereNull("email_verified_at")->first();
        
        if(!$user){
            return failResponse("الرجاء ارسال الكود مرة اخري");
        }

        $user->update([
            "email_verified_at"=>now(),
        ]);

        return successResponse(message:"تم النحقيق من البريد الاكتروني بنجاح");
    }

    public function sendResetPasswordCode(Request $request){
        
        $validation=validator()->make($request->only(["email","url"]),[
            "email"=>"required|string|exists:users,email|email",
            "url"=>"required|string|exists:companies,url",
        ]);

        if($validation->fails()){
            return failResponse($validation->errors());
        }

        $validation->validated();

        $user=User::where("email",'=',$request->input("email"))->whereHas("company",function($query){
            $query->where("url",'=',request()->input('url'));
        })->first();

        if(!$user){
            return failResponse(__("auth.failed"));
        }

        (new UserService())->sendResetPasswordConfirmation($user);
        
        return successResponse(message:'تم ارسال الكود الي بريدك الاكتروني بنجاح');
    }

    public function resetPassword(Request $request){
        
        $validation=validator()->make($request->only(["code","password_confirmation","password"]),[
            "code"=>"required|string|exists:users,pin_code",
            "password"=>"required|min:8|string|confirmed",
        ]);

        if($validation->fails()){
            return failResponse($validation->errors());
        }

        $validation->validated();

        $user=User::where('pin_code','=',$request->input("code"))->first();

        $user->update([
            "password"=>Hash::make($request->input("password")),
        ]);

        return successResponse(message:"تم تحديث البيانات بنجاح");
    }

}
