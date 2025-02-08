<?php

namespace App\Models;

use App\Enums\GranderEnums;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;
    protected $fillable =['name',"personal_id","personal_image","image","first_phone","second_phone",'status',"grander","jop","salary"];
    
    public function user(){
        return $this->belongsTo(User::class);
    }
    protected function casts(){
        return [
            'status'=>"boolean",
            "grander"=>GranderEnums::class,
        ];
    }

}
