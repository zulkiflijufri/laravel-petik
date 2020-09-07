<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            'title' => 'required',
            'content' => 'required',
            'location' => 'required',
            'date' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Judul harus diisi!',
            'content.required' => 'Kontent harus diisi!',
            'location.required' => 'Lokasi harus diisi!',
            'date.required' => 'Tanggal harus diisi!'
        ];
    }
}
