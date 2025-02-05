<?php

namespace App\Models;

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

}
