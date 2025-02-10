<?php

namespace App\Models;

use App\Enums\GranderEnums;
use Illuminate\Database\Eloquent\Builder;
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

  public function scopeByCompany(Builder $builder,$company_id){
    return $builder->whereHas('user',function($query)use($company_id){
      $query->whereHas('company',function($query)use($company_id){
          $query->where('companies.id','=',$company_id);
      });
    });
}

}
