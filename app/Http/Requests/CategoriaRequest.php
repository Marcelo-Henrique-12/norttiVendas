<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriaRequest extends FormRequest
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
            'nome' => ['required','string','max:255'],
            'icone' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'descricao' => ['required', 'string','max:1000'],
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O campo nome é obrigatório',
            'nome.string' => 'O campo nome deve ser uma string',
            'nome.max' => 'O campo nome deve ter no máximo 255 caracteres',
            'icone.required' => 'O campo icone é obrigatório',
            'icone.image' => 'O campo icone deve ser uma imagem',
            'icone.mimes' => 'O campo icone deve ser uma imagem do tipo: jpeg, png, jpg, gif, svg',
            'icone.max' => 'O campo icone deve ter no máximo 2048 bytes',
            'descricao.required' => 'O campo descrição é obrigatório',
            'descricao.string' => 'O campo descrição deve ser uma string',
            'descricao.max' => 'O campo descrição deve ter no máximo 1000 caracteres',
        ];
    }
}
