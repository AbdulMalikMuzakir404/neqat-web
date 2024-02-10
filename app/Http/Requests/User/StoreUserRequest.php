<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|string|min:5|max:50',
            'username' => 'required|string|min:5|max:50|unique:users,username',
            'email' => 'required|email|min:8|max:70|unique:users,email',
            'password' => 'required|min:8|max:100',
            'role' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nama',
            'username' => 'username',
            'email' => 'email',
            'password' => 'kata sandi'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attribute tidak boleh kosong',
            'username.required' => ':attribute tidak boleh kosong',
            'email.required' => ':attribute tidak boleh kosong',
            'password.required' => ':attribute tidak boleh kosong',

            'name.max' => ':attribute melebihi batas maksimal karakter',
            'username.max' => ':attribute melebihi batas maksimal karakter',
            'email.max' => ':attribute melebihi batas maksimal karakter',
            'password.max' => ':attribute melebihi batas maksimal karakter',

            'username.uniqid' => ':attribute sudah terdaftar',
            'email.uniqid' => ':attribute sudah terdaftar',
        ];
    }
}
