<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateModeloRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'marca_id' => 'exists:marcas,id',
            'nome' => 'required|min:3|unique:modelos',
            'imagem' => 'required|file|max:64000|mimes:jpg,jpeg,bmp,png,pdf',
            'numero_portas' => 'required|integer|digits_between: 1,5',
            'lugares' => 'required|integer|digits_between: 1,20',
            'air_bag' => 'required|boolean',
            'abs' => 'required|boolean',
        ];
    }
}
