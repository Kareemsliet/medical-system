<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use SoftDeletes;
    protected $fillable = ['name','company_id','first_phone', 'second_phone', 'image', 'commission', 'status', 'personal_id', 'signature', 'user_id'];  

    protected $table='doctors';

    public $timestamps = true;

    public function user(){
    
        return $this->belongsTo(User::class);
    }

    protected function casts(){
        return [
            'commission' => 'float',
            'status' => 'boolean'
        ];
    }

    public function actions(){
        return $this->hasMany(DoctorAction::class,'doctor_id');
    }
}
