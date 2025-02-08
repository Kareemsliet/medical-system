<?php

namespace App\Models;

use App\Enums\GranderEnums;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
 
  use SoftDeletes;
  protected $fillable =['name',"another_name","personal_id","personal_image","first_phone","second_phone",'status',"grander","description"];
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
