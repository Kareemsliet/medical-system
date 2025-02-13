<?php

namespace App\Http\Requests\Api;

use App\Rules\UniqueEmailCompany;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
        $user=auth("sanctum")->user();

        return [
            "image"=>$this->whenHas("image",function(){
                return "image|max:15000|mimes:png,jpg,svg";
            },function(){
                return "nullable";
            }),
            "signature"=>$this->whenHas("signature",function(){
                return "image|max:15000|mimes:png,jpg,svg";
            },function(){
                return "nullable";
            }),
            "personal_image"=>$this->whenHas("personal_image",function(){
                return "image|max:15000|mimes:png,jpg,svg";
            },function(){
                return "nullable";
            }),
            "first_phone"=>$this->when(function()use($user){
                return $user->isRole("patient");
            },function()use($user){
                return "nullable|numeric|unique:patients,first_phone,{$user->patient->id}|unique:patients,second_phone,{$user->patient->id}";
            },function(){
                return "nullable";
            }),
            "second_phone"=>$this->when(function()use($user){
                return  $user->isRole("patient");
            },function()use($user){
                return "nullable|numeric|unique:patients,first_phone,{$user->patient->id}|unique:patients,second_phone,{$user->patient->id}";
            },function(){
                return "nullable";
            }),
            "another_name"=>$this->when(function()use($user){
                return  $user->isRole("patient");
            },function()use($user){
                return "nullable|string|unique:patients,name,{$user->patient->id}|unique:patients,another_name,{$user->patient->id}}";
            },function(){
                return "nullable";
            }),
            "email"=>$this->when(function()use($user){
                return  $user->isRole("patient");
            },function()use($user){
                return ["nullable","string","email",new UniqueEmailCompany("users",$user->id)];
            },function(){
                return "nullable";
            }),
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator){
        return failResponse($validator->errors()->first());
    }

}
