<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name' => 'required|min:3|unique:categories'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Kategori harus diisi!',
            'name.min'  => 'Kategori minimal 3 karakter!',
            'name.unique'   => 'Kategori ini sudah ada!'
        ];
    }
}
