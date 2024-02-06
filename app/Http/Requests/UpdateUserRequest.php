<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required|string|max:50',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|max:70|unique:users,email',
            'password' => 'required|max:100'
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
