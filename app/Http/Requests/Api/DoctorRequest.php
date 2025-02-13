<?php

namespace App\Http\Requests\Api;

use App\Models\Doctor;
use App\Rules\UniqueEmailCompany;
use Illuminate\Foundation\Http\FormRequest;

class DoctorRequest extends FormRequest
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
       $doctor=$this->route('doctor',0);
       
       return [
            "name" => "required|string|max:100|unique:doctors,name,$doctor",
            "first_phone" => "required|unique:doctors,first_phone,$doctor|unique:doctors,second_phone,$doctor",
            "second_phone" => "nullable|unique:doctors,second_phone,$doctor|unique:doctors,first_phone,$doctor",
            "image" => $this->whenHas('image',function(){
                return "image|max:15000|mimes:png,jpg,jpeg";
            },function(){
                return "nullable";
            }),
            "commission" => "required|numeric",
            "personal_id" => "required|unique:doctors,personal_id,$doctor",
            "status" => "required|in:0,1",
            "signture" => $this->whenHas('signture',function(){
                return "image|max:15000|mimes:png,jpg,jpeg";
            },function(){
                return "nullable";
            }),
            "clinics"=>"required|array",
            "clinics.*"=>"required|exists:clinics,id",
            "register_id"=>"required|string|unique:doctors,register_id,$doctor",
            "email"=>$this->when(function()use($doctor){
                return ($this->getMethod() == "PUT" || $this->getMethod() == "PATCH") &&  Doctor::find($doctor);
            },function(){
                return ["nullable","email","string",new UniqueEmailCompany("users",Doctor::find($this->route("doctor"))->user->id)];
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
            "gender"=>"required|in:male,female",
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator){
        return failResponse($validator->errors()->first());
    }

}
