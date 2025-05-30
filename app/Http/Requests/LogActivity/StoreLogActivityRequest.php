<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreLogActivityRequest extends FormRequest
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
            'description' => 'required|string|min:5|max:100',
        ];
    }

    public function attributes()
    {
        return [
            'description' => 'keterangan',
        ];
    }

    public function messages()
    {
        return [
            'description.required' => ':attribute tidak boleh kosong',

            'description.max' => ':attribute melebihi batas maksimal karakter',

            'description.min' => ':attribute harus lebih dari 5 karakter',
        ];
    }
}
