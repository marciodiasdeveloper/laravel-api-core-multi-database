<?php

namespace App\Http\Requests\SignUp;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class CheckEmailRequest extends FormRequest
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
            'email' => 'email|required'
        ];
    }

    public function attributes()
    {
        return [
            'email' => [
                'email' => 'E-mail address is not valid.',
                'required' => 'We need to know your email address!',
            ]
        ];
    }
}
