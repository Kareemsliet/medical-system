<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
        return [
            'name'=>"required|string",
            "twitter_link"=>"nullable|string|url",
            "facebook_link"=>"nullable|string|url",
            'description'=>"nullable|string|max:250",
            'logo'=>"nullable|image|mimes:png,jpg,svg,jpeg|max:5550",
        ];
    }
}
