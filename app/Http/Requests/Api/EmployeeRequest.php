<?php

namespace App\Http\Requests\Api;

use App\Models\Employee;
use App\Rules\UniqueEmailCompany;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
       $employee=$this->route('employee',0);
       return [
            "name" => "required|string|max:100|unique:employees,name,$employee",
            "first_phone" => "required|unique:employees,first_phone,$employee|unique:employees,second_phone,$employee",
            "second_phone" => "nullable|unique:employees,second_phone,$employee|unique:employees,first_phone,$employee",
            "image" => $this->whenHas('image',function(){
                return "image|max:15000|mimes:png,jpg,jpeg";
            },function(){
                return "nullable";
            }),
            "personal_id" => "required|unique:employees,personal_id,$employee",
            "status" => "required|in:0,1",
            "personal_image" => $this->whenHas('personal_image',function(){
                return "image|max:15000|mimes:png,jpg,jpeg";
            },function(){
                return "nullable";
            }),
            "jop"=>"string|required",
            "gender"=>"required|in:male,female",
            "salary"=>"required|numeric",
            "role"=>"required||in:admin,employee|string",
            "email"=>$this->when(function()use($employee){
                return ($this->getMethod() == "PUT" || $this->getMethod() == "PATCH") &&  Employee::find($employee);
            },function(){
                return ["nullable","email","string",new UniqueEmailCompany("users",Employee::find($this->route("employee"))->user->id)];
            },function(){
                return ["required","email","string",new UniqueEmailCompany("users")];
            }),
            "password"=>$this->when(function(){
                return $this->getMethod() == "PUT" || $this->getMethod() == "PATCH";
            },function(){
                return "nullable|min:8|string";
            },function(){
                return "required|min:8|string";
            }),
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator){
        return failResponse($validator->errors()->first());
    }

}
