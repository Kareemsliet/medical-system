<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoctorAction extends Model
{
    use SoftDeletes;
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
