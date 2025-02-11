<?php

namespace App\Models;

use App\Enums\GranderEnums;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use SoftDeletes;
    protected $fillable = ['name','company_id','first_phone', 'second_phone', 'image', 'commission', 'status', 'personal_id', 'signature','register_id',"user_id","grander"];  

    protected $table='doctors';

    public $timestamps = true;

    public function user(){
    
        return $this->belongsTo(User::class);
    }

    protected function casts(){
        return [
            'commission' => 'float',
            'status' => 'boolean',
            "grander"=>GranderEnums::class,
        ];
    }
    public function actions(){
        return $this->hasMany(DoctorAction::class,'doctor_id');
    }

    public function clinics(){
        return $this->belongsToMany(Clinic::class,'clinic_doctor','doctor_id','clinic_id')->withTimestamps();
    }

    public function scopeByCompany(Builder $builder,$company_id){
        return $builder->whereHas('user',function($query)use($company_id){
          $query->whereHas('company',function($query)use($company_id){
              $query->where('companies.id','=',$company_id);
          });
        });
    }

}
