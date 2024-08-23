<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePerfilRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $this->user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required_with:password', 'same:password'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório',
            'name.max' => 'O campo nome deve ter no máximo 255 caracteres',
            'email.required' => 'O campo email é obrigatório',
            'email.email' => 'O campo email deve ser um email válido',
            'email.max' => 'O campo email deve ter no máximo 255 caracteres',
            'email.unique' => 'O email informado já está em uso',
            'password.min' => 'O campo senha deve ter no mínimo 8 caracteres',
            'password.confirmed' => 'As senhas não conferem',
            'password_confirmation.same' => 'As senhas não conferem',
            'password_confirmation.required_with' => 'O campo de confirmação de senha é obrigatório',
        ];
    }
}
