<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasApiTokens,HasRoles,SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'email',
        'password',
        "company_id",
        "email_verified_at",
        "email_verified_code",
        "pin_code",
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            "email_verified_at"=>"datetime",
        ];
    }
    public function doctor(){
        return $this->hasOne(Doctor::class,'user_id');
    }

    public function patient(){
        return $this->hasOne(Patient::class,'user_id');
    }

    public function employee(){
        return $this->hasOne(Employee::class,'user_id');
    }
    public function isRole(string $role){
        
        return $this->whereHas("$role",function($query){
            $query->where("user_id",'=',$this->id);
        })->exists();
    }
    public function company(){
        $this->hasVerifiedEmail();
        return $this->belongsTo(Company::class);
    }

    public function getName(){
        $name="";

        if($this->isRole("patient")){
            $name=$this->patient->name;
        }

        if($this->isRole("doctor")){
            $name=$this->doctor->name;
        }

        if($this->isRole("employee")){
            $name=$this->employee->name;
        }

        return $name;
    }

    public function getStatus(){

        $status=false;

        if($this->isRole("patient")){
            $status=$this->patient->status;
        }

        if($this->isRole("doctor")){
            $status=$this->doctor->status;
        }

        if($this->isRole("employee")){
            $status=$this->employee->status;
        }

        return $status;

    }

}
