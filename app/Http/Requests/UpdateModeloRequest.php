<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateModeloRequest extends FormRequest
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
            'nome' => 'min:3|unique:modelos,id,' . $this->route('modelo'),
            'imagem' => 'file|max:64000|mimes:jpg,jpeg,bmp,png,pdf',
            'numero_portas' => 'integer|digits_between: 1,5',
            'lugares' => 'integer|digits_between: 1,20',
            'air_bag' => 'boolean',
            'abs' => 'boolean',
        ];
    }
}
