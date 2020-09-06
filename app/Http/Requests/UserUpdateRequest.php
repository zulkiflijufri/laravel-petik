<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$this->user->id.',id',
            'password' => 'min:6|confirmed',
            'role' => 'required|array|min:1'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'User harus diisi!',
            'email.required' => 'Email harus diisi!',
            'email.unique' => 'Email ini sudah ada!',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai!',
            'role.required'  => 'Role harus diisi!'
        ];
    }
}
