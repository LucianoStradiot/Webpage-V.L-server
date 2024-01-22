<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Login extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }



    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                'regex:/^[a-z0-9._%+-]+@[a-z.-]+\.(com\.ar|com)$/'
            ],
            'password' => ['required', 'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d]{8,}$/']
        ];
    }


    public function messages()
    {
        return [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Ingresa una dirección de correo electrónico válida.',
            'email.regex' => 'El correo electrónico ingresado no respeta el formato correcto.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.regex' => 'La contraseña debe tener al menos 8 caracteres, una letra mayúscula, minúscula y un número.',
        ];
    }

}

