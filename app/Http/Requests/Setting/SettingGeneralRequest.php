<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class SettingGeneralRequest extends FormRequest
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
            'school_name' => 'required|max:50',
            'school_time_from' => 'required',
            'school_time_to' => 'required',
            'school_hour_tolerance' => 'required',
            'absen' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'school_name' => 'nama sekolah',
            'school_time_from' => 'jam masuk sekolah',
            'school_time_to' => 'jam pulang sekolah',
            'school_hour_tolerance' => 'jam batas checkin',
            'absen' => 'absen'
        ];
    }

    public function messages()
    {
        return [
            'school_name.required' => ':attribute tidak boleh kosong',
            'school_time_from.required' => ':attribute tidak boleh kosong',
            'school_time_to.required' => ':attribute tidak boleh kosong',
            'school_hour_tolerance.required' => ':attribute tidak boleh kosong',
            'absen.required' => ':attribute tidak boleh kosong',

            'school_name.max' => ':attribute melebihi batas maksimal karakter',
        ];
    }
}
