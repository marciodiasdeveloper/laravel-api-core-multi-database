<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;

class TenantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|max:100',
            'domain' => 'required|min:3|max:191|unique:tenants,domain,{$id}',
            'db_database' => 'required|min:3|max:191|unique:tenants,db_database,{$id}',
            'db_host' => 'required|min:3|max:100',
            'db_username' => 'required|min:3|max:100',
            'db_password' => 'required|min:3|max:100',
            'db_port' => 'required|min:1|max:20',
        ];
    }
}
