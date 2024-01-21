<?php

namespace App\Http\Requests\Password;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPassword extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => [
                'required',
                'regex:/^[a-z0-9._%+-]+@[a-z.-]+\.(com\.ar|com)$/'
            ]
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'El email es obligatorio.',
            'email.regex' => 'El formato del email debe ser nombre@dominio.com o .com.ar.'
        ];
    }
}