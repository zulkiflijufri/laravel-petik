<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
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
            'name' => 'required|unique:tags|min:3'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tag harus diisi!',
            'name.min'      => 'Tag minimal 3 karakter',
            'name.unique'   => 'Tag ini sudah ada!'
        ];
    }
}
