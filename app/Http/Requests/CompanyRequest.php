<?php

namespace App\Http\Requests;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
        $company=$this->route("company");
        return [
            "company_name"=>"required|string|unique:companies,name,$company",
            "email"=>"required|email|string",
            "password"=>"required|string|min:8|confirmed",
            "url"=>"nullable|string|url",
            "phone_manager"=>"nullable|string|unique:companies,phone_manager,$company",
            "name_manager"=>"nullable|string",
            "admin_name"=>"required|string",
            "plan_id"=>"required|exists:plans,id",
        ];
    }
}
