<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clinic extends Model
{
    use SoftDeletes;
    protected $fillable=['name','status','company_id'];
    protected $table= 'clinics';
    protected function casts(){
        return [
            'status'=>"boolean",
        ];
    }
    public function company(){
        return $this->belongsTo(Company::class);
    }
    public function doctors(){
        return $this->belongsToMany(Doctor::class,'clinic_doctor','clinic_id','doctor_id');
    }

    public function scopeByCompany(Builder $builder,$company_id){
        return $builder->whereHas('company',function($query)use($company_id){
            $query->where('id','=',$company_id);
        });
    }

}
