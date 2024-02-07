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
            'user_id' => 'required|string|max:11',
            'name_edit' => 'required|string|min:5|max:50',
            'username_edit' => 'required|string|min:5|max:50|unique:users,username, ' . $this->user_id,
            'email_edit' => 'required|email|min:8|max:70|unique:users,email,' . $this->user_id,
            'password_edit' => 'nullable|min:8|max:100',
            'role_edit' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'name_edit' => 'nama',
            'username_edit' => 'username',
            'email_edit' => 'email',
            'password_edit' => 'kata sandi',
            'role_edit' => 'Role'
        ];
    }

    public function messages()
    {
        return [
            'name_edit.required' => ':attribute tidak boleh kosong',
            'username_edit.required' => ':attribute tidak boleh kosong',
            'email_edit.required' => ':attribute tidak boleh kosong',
            'password_edit.required' => ':attribute tidak boleh kosong',
            'role_edit.required' => ':attribute tidak boleh kosong',

            'name_edit.max' => ':attribute melebihi batas maksimal karakter',
            'username_edit.max' => ':attribute melebihi batas maksimal karakter',
            'email_edit.max' => ':attribute melebihi batas maksimal karakter',
            'password_edit.max' => ':attribute melebihi batas maksimal karakter',

            'username_edit.uniqid' => ':attribute sudah terdaftar',
            'email_edit.uniqid' => ':attribute sudah terdaftar',
        ];
    }
}
