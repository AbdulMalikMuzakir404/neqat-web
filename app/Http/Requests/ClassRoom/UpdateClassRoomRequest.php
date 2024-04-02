<?php

namespace App\Http\Requests\ClassRoom;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClassRoomRequest extends FormRequest
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
            'classname' => 'required|string|max:10',
            'major' => 'required|string|min:5|max:100',
        ];
    }

    public function attributes()
    {
        return [
            'classname' => 'nama kelas',
            'major' => 'nama jurusan',
        ];
    }

    public function messages()
    {
        return [
            'classname.required' => ':attribute tidak boleh kosong',
            'major.required' => ':attribute tidak boleh kosong',

            'classname.max' => ':attribute melebihi batas maksimal karakter',
            'major.max' => ':attribute melebihi batas maksimal karakter',

            'major.min' => ':attribute harus lebih dari 5 karakter',
        ];
    }
}
