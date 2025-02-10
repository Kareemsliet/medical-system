<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Management extends Authenticatable
{
    use SoftDeletes,HasRoles;
    protected $fillable = ['email','password','name'];
}
