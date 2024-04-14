<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
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
            'classroom' => 'required',
            'gender' => 'required',
            'nis' => 'required|max:12|unique:students,nis',
            'nisn' => 'required|max:14|unique:students,nisn',
            'phone' => 'required|max:15',
            'birth_place' => 'required|string|max:50',
            'birth_date' => 'required',
            'address' => 'required|string|max:100'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nama',
            'username' => 'username',
            'email' => 'email',
            'password' => 'kata sandi',
            'classroom' => 'kelas',
            'gender' => 'jenis kelamin',
            'nis' => 'nis',
            'nisn' => 'nisn',
            'phone' => 'number hp',
            'birth_place' => 'tempat lahir',
            'birth_date' => 'tanggal lahir',
            'address' => 'alamat'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attribute tidak boleh kosong',
            'username.required' => ':attribute tidak boleh kosong',
            'email.required' => ':attribute tidak boleh kosong',
            'password.required' => ':attribute tidak boleh kosong',
            'classroom.required' => ':attribute tidak boleh kosong',
            'gender.required' => ':attribute tidak boleh kosong',
            'nis.required' => ':attribute tidak boleh kosong',
            'nisn.required' => ':attribute tidak boleh kosong',
            'phone.required' => ':attribute tidak boleh kosong',
            'birth_place.required' => ':attribute tidak boleh kosong',
            'birth_date.required' => ':attribute tidak boleh kosong',
            'address.required' => ':attribute tidak boleh kosong',

            'name.max' => ':attribute melebihi batas maksimal karakter',
            'username.max' => ':attribute melebihi batas maksimal karakter',
            'email.max' => ':attribute melebihi batas maksimal karakter',
            'password.max' => ':attribute melebihi batas maksimal karakter',
            'nis.max' => ':attribute melebihi batas maksimal karakter',
            'nisn.max' => ':attribute melebihi batas maksimal karakter',
            'phone.max' => ':attribute melebihi batas maksimal karakter',
            'birth_place.max' => ':attribute melebihi batas maksimal karakter',
            'address.max' => ':attribute melebihi batas maksimal karakter',

            'username.unique' => ':attribute sudah terdaftar',
            'email.unique' => ':attribute sudah terdaftar',
            'nis.unique' => ':attribute sudah terdaftar',
            'nisn.unique' => ':attribute sudah terdaftar',
        ];
    }
}
