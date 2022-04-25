<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'name' => 'required|max:255',
            'description' => 'string|nullable',
            'price' => 'string|required',
            'stock' => 'integer|nullable',
            // 'cover' => 'file|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cover' => 'file|nullable',
        ];
    }

    public function messages(){
        return [
            'name.required' => 'O nome do produto é obrigatório',
            'name.max' => 'O nome do produto deve ter no máximo 255 caracteres',
            'price.required' => 'O preço do produto é obrigatório',
            'stock.integer' => 'O estoque do produto deve ser um número',
            'cover.file' => 'O arquivo deve ser uma imagem',
            'cover.max' => 'A imagem deve ter no máximo 2MB',
        ];
    }
}
