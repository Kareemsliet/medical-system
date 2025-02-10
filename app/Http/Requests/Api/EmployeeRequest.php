<?php

namespace App\Http\Requests\Api;

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
            "grander"=>"required|in:male,female",
            "email"=>"required|email|string",
            "salary"=>"required|numeric",
            "role"=>"required||in:admin,employee|string",
            "password"=>"required|string|min:8",
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator){
        return failResponse($validator->errors()->first());
    }

}
