<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendaRequest extends FormRequest
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
            'total' => ['required', 'numeric'],
            'produtos' => ['required', 'array'],
            'produtos.*.id' => ['required', 'exists:produtos,id'],
            'produtos.*.quantidade' => ['required', 'numeric', 'min:1'],
        ];
    }

    public function messages()
    {
        return [
            'total.required' => 'O campo total é obrigatório',
            'total.numeric' => 'O campo total deve ser um número',
            'produtos.required' => 'O campo produtos é obrigatório',
            'produtos.array' => 'O campo produtos deve ser um array',
            'produtos.*.id.required' => 'O campo id do produto é obrigatório',
            'produtos.*.id.exists' => 'O produto informado não existe',
            'produtos.*.quantidade.required' => 'O campo quantidade é obrigatório',
            'produtos.*.quantidade.numeric' => 'O campo quantidade deve ser um número',
            'produtos.*.quantidade.min' => 'A quantidade deve ser no mínimo 1',
        ];
    }
}
