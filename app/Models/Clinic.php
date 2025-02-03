<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    protected $fillable=['name','status'];
    protected $table= 'clinics';
    protected function casts(){
        return [
            'status'=>"boolean",
        ];
    }
}
