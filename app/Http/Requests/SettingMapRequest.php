<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingMapRequest extends FormRequest
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
            'location_name' => 'required|max:100',
            'latitude' => 'required|max:50',
            'longitude' => 'required|max:50',
            'radius' => 'required|max:11'
        ];
    }

    public function attributes()
    {
        return [
            'location_name' => 'nama lokasi',
            'latitude' => 'latitude',
            'longitude' => 'longitude',
            'radius' => 'radius'
        ];
    }

    public function messages()
    {
        return [
            'location_name.required' => ':attribute tidak boleh kosong',
            'latitude.required' => ':attribute tidak boleh kosong',
            'longitude.required' => ':attribute tidak boleh kosong',
            'radius.required' => ':attribute tidak boleh kosong',

            'location_name.max' => ':attribute melebihi batas maksimal karakter',
            'latitude.max' => ':attribute melebihi batas maksimal karakter',
            'longitude.max' => ':attribute melebihi batas maksimal karakter',
            'radius.max' => ':attribute melebihi batas maksimal karakter',
        ];
    }
}
