<?php

namespace App\Http\Services;

use App\Models\User;
use App\Notifications\EmailVerification;
use App\Notifications\ResetPassword;
use Spatie\Permission\Models\Role;

class UserService {
    
    protected $company;
    public function __construct(){
        $this->company=auth('sanctum')->check()?auth("sanctum")->user()->company:null;
    }
    
    public function store($data,$roleName){
        $user=$this->company->users()->create($data);

        $role=Role::where("name",$roleName)->first();

        $user->syncRoles([$role]);

        $this->sendEmailVerification($user);

        return $user;
    }

    public function update($user_id,$data){
        $user_id->update($data);
    }

    public function generateCode(){
        $code=rand(111111,999999);
        return $code;
    }

    public function generateEmailVerificationCode(){
        
        $code=$this->generateCode();

        $exits_code=User::where("email_verified_code",'=',$code)->exists();

        if($exits_code){
            $code=$this->generateCode();
        }

        return $code;
    }

    public function generateResetPasswordCode(){
        
        $code=$this->generateCode();

        $exits_code=User::where("pin_code",'=',$code)->exists();

        if($exits_code){
            $code=$this->generateCode();
        }

        return $code;
    }

    public function sendEmailVerification($user){
        $code=$this->generateEmailVerificationCode();

        $user->update([
            "email_verified_code"=>$code,
        ]);

        $user->notify(new EmailVerification($code,$user->getName()));
    }

    public function sendResetPasswordConfirmation($user){
        
        $code=$this->generateResetPasswordCode();

        $user->update([
            "pin_code"=>$code,
        ]);

        $user->notify(new ResetPassword($code,$user->getName()));
    }



}