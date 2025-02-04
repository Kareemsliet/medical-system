<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorAction extends Model
{
   protected $table="doctor_actions";
    protected $fillable = ['doctor_id', 'name', 'price'];

    protected $hidden = ['id'];

    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }

    protected function casts(){
        return [
            'price' => 'float'
        ];
    }
}
