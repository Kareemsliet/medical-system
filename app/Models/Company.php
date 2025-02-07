<?php

namespace App\Models;
use App\Models\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravelcm\Subscriptions\Traits\HasPlanSubscriptions;

#[ScopedBy([CompanyScope::class])]
class Company extends Model
{
    use SoftDeletes,HasPlanSubscriptions;
    protected $fillable=["name","url","name_manager","phone_manager"];
    public function clinics(){
        return $this->hasMany(Clinic::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }

}

