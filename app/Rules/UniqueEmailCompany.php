<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueEmailCompany implements Rule
{
    protected int $companyId;
    protected string $table;
    protected  $exceptedId;
    public function __construct($table,$exceptedId=null){
        $this->companyId=auth('sanctum')->user()->company->id;
        $this->table=$table;
        $this->exceptedId=$exceptedId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function passes($attribute, $value)
    {
        return !DB::table($this->table)
        ->when($this->exceptedId, function($query){
            $query->where('id','!=',$this->exceptedId);
        })
        ->where("email",'=',$value)
        ->where("company_id",'=',$this->companyId)->exists();

    }

    public function message(){
        return __("validation.unique");
    }


}
