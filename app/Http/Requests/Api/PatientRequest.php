<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
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
        $patient=$this->route("patient",0);

        return [
            "name"=>"required|string|unique:patients,name,$patient|unique:patients,another_name,$patient",
            "another_name"=>"nullable|string|unique:patients,another_name,$patient|unique:patients,name,$patient",
            "first_phone"=>"required|string|unique:patients,first_phone,$patient|unique:patients,second_phone,$patient",
            "second_phone"=>"nullable|string|unique:patients,second_phone,$patient|unique:patients,first_phone,$patient",
            "personal_id"=>"required|string|unique:patients,personal_id,$patient",
            "personal_image"=>$this->whenHas("personal_image",function(){
                return "image|mimes:png,jpg,svg|max:15000";
            },function(){
                return "nullable";
            }),
            "status"=>"required|in:0,1",
            "grander"=>"required|in:male,female",
            "description"=>"required|string|max:250",
            "email"=>$this->when(function(){
                return $this->getMethod() == "PUT" || $this->getMethod() == "PATCH";
            },function(){
                return "nullable|email|string";
            },function(){
                return "required|email|string";
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
