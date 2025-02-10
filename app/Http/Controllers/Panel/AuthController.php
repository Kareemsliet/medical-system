<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Management;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm(){
        return view("panel.auth.login");
    }
    public function login(Request $request){
        
        $request->validate([
            'email'=>"required|string|email",
            "password"=>"required|string|min:8",
            "remember"=>"nullable|boolean",
        ]);

        if(!auth('manager')->attempt($request->only(['email','password']),$request->remember?true:false)){
           return redirect()->back()->withInput(['email'=>$request->email])->withErrors(["email"=>"الايميل او كلمة المرور غير صحيحة"]);   
        }

        return redirect()->route("panel.index")->with("message","اتمام عملية تسجيل الدخول بنجاح");
    }

    public function logout(Request $request){

        auth('manager')->logout();

        return redirect()->route('panel.login')->with('message',"تم تسجيل الخروج بنجاح");
    }

    public function showForgetPasswordForm(){
        return view("panel.auth.password");
    }

    public function updatePassword(Request $request){
        $request->validate([
            "email"=>"required|email|exists:management,email",
            "password"=> "required|string|min:8|confirmed",
        ]);

        $manager = Management::where("email",$request->email)->first();

        if(!$manager){
            return redirect()->back()->withErrors(["email"=>"هذا الايميل غير موجود"]);
        }

        $manager->update([
            "password"=> bcrypt($request->password),
        ]);

        return redirect()->route("panel.login");
    }

}
