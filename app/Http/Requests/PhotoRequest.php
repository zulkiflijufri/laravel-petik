<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhotoRequest extends FormRequest
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
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'caption' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'image.required' => 'Gambar harus diisi!',
            'image.image' => 'Pastikan file berupa gambar',
            'image.mimes' => 'Pastikan format gambar .jpeg, .jpg, atau .png',
            'image.max' => 'Ukuran max 2 MB',
            'caption.required' => 'Judul harus diisi!',
        ];
    }
}
