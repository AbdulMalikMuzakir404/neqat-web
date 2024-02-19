<?php

namespace App\Http\Requests\Announcement;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnnouncementRequest extends FormRequest
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
            'title' => 'required|string|min:5|max:50',
            'description' => 'required|string|min:10',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'judul',
            'deskription' => 'deskripsi',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => ':attribute tidak boleh kosong',
            'description.required' => ':attribute tidak boleh kosong',

            'title.max' => ':attribute melebihi batas maksimal karakter',

            'title.min' => ':attribute harus lebih dari 5 karakter',
            'description.min' => ':attribute harus lebih dari 10 karakter',
        ];
    }
}
