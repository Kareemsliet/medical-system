<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ["name","status","category_id","company_id"];

    public function category(){
        return $this->belongsTo(ExpenseCategory::class,"category_id");
    }
    public function company(){
        return $this->belongsTo(Company::class);
    }

    protected function casts(){
        return [
            "status" => "boolean",
        ];
    }
}
