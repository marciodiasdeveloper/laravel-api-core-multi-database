<?php

namespace App\Http\Requests\SignUp;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class SignUpRequest extends FormRequest
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
            'step1' => [
                'personal' => [
                    'catalog' => [
                        'name' => 'required',
                        'phone' => [
                            'mobile' => 'required'
                        ]
                    ],
                    'user' => [
                        'email' => 'email|required',
                        'password' => 'required|min:6',
                    ],
                    'job' => 'required'
                ]
            ],
            'step2' => [
                'company' => [
                    'name' => 'required',
                    'phone' => 'required',
                    'occupation_area' => 'required',
                    'employees_number' => 'required|integer'
                ]
            ],
            'step3' => 'required|array|min:1',
            'step4' => [
                'domain' => 'required'
            ],
            'step5' => [
                'method' => 'required',
                'type' => 'required'
            ]
        ];
    }

    public function attributes()
    {
        return [
            'step1' => [
                'personal' => [
                    'catalog' => [
                        'name' => [
                            'required' => 'We need to know your email address!',
                        ],
                        'phone' => [
                            'mobile' => [
                                'required' => 'Field required'
                            ]
                        ]
                    ],
                    'user' => [
                        'email' => [
                            'email' => 'Email is not valid',
                            'required' => 'We need to know your email address!',
                        ],
                        'password' => [
                            'required' => 'We need to know your password!',
                            'min' => 'Password must be at least 6 characters'
                        ]
                    ],
                    'job' => [
                        'required' => 'We need to know your job!'
                    ]
                ],
            ],
            'step2' => [
                'company' => [
                    'name' => [
                        'required' => 'We need to know your company name!'
                    ],
                    'phone' => [
                        'required' => 'We need to know your company phone!'
                    ],
                    'occupation_area' => [
                        'required' => 'We need to know your company ocupation area!'
                    ],
                    'employees_number' => [
                        'required' => 'We need to know your company employees number!',
                        'integer' => 'Employees number must be a number!'
                    ]
                ]
            ],
            'step3' => [
                'required' => 'We need to know your company products!',
                'min' => 'You must select at least one product!'
            ],
            'step4' => [
                'domain' => [
                    'required' => 'We need to know your company domain!'
                ]
            ],
            'step5' => [
                'method' => [
                    'required' => 'We need to know your send verification code method!'
                ],
                'type' => [
                    'required' => 'We need to know your verifcation code type!'
                ]
            ]
        ];
    }
}
