<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class ImportRequest extends FormRequest
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
            'file' => 'required|mimes:csv,xls,xlsx|max:5120',
        ];
    }

    public function attributes()
    {
        return [
            'file' => 'berkas',
        ];
    }

    public function messages()
    {
        return [
            'file.required' => ':attribute tidak boleh kosong',

            'file.max' => ':attribute melebihi batas maksimal upload',

            'file.mimes' => ':attribute hanya bisa upload file .csv, .xls, dan .xlsx',
        ];
    }
}
