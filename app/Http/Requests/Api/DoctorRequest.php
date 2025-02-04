<?php

namespace App\Http\Requests\Api;

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
       $id=$this->route('doctor',0);
       return [
            "name" => "required|string|max:100",
            "first_phone" => "required|max:20|unique:doctors,first_phone,$id",
            "second_phone" => "nullable|max:20|unique:doctors,second_phone,$id",
            "image" => $this->whenHas('image',function(){
                return "image|max:15000|mimes:png,jpg,jpeg";
            },function(){
                return "nullable";
            }),
            "commission" => "required|numeric",
            "personal_id" => "required|max:20|unique:doctors,personal_id,$id",
            "status" => "required|in:0,1",
            "signture" => $this->whenHas('image',function(){
                return "image|max:15000|mimes:png,jpg,jpeg";
            },function(){
                return "nullable";
            }),
            "user_id"=>"required|exists:users,id",
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator){
        return failResponse($validator->errors()->first());
    }

}
