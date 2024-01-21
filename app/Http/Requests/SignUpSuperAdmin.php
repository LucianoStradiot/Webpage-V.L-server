<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignUpSuperAdmin extends FormRequest
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
                'regex:/^[a-z0-9._%+-]+@[a-z.-]+\.(com\.ar|com)$/',
                'unique:super_admins,email',
            ],
            'password' => ['required', 'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d]{8,}$/']
        ];
    }


    public function messages()
    {
        return [
            'email.unique' => 'El email ya se encuentra registrado.',
            'email.required' => 'El email es obligatorio.',
            'email.regex' => 'El formato del email debe ser nombre@dominio.com o .com.ar.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.regex' => 'La contraseña debe tener al menos 8 caracteres, una letra mayúscula, minúscula y un número.',
        ];
    }

}
