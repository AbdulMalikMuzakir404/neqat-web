<?php

namespace App\Imports\Student;

use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Import implements ToModel, WithHeadingRow
{
    protected $model, $role;

    public function __construct($model, $role)
    {
        $this->model = $model;
        $this->role = $role;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        try {
            // Cek apakah ada pengguna dengan email atau username yang sama
            $existingUser = $this->model->where('email', $row['email'])
                ->orWhere('username', $row['username'])
                ->get();

            if ($existingUser->count() >= 1) {
                return null;
                Log::info("Student export info: data import duplicate");
            }

            $import = $this->model->create([
                'name' => $row['nama'],
                'username' => $row['username'],
                'email' => $row['email'],
                'password' => Hash::make($row['password']),
            ]);

            $role = $this->role->where('name', 'student')->first();

            $import->assignRole($role);

            // Simpan data student ke dalam database
            $import->save();

            if ($import) {
                return $import;
            } else {
                return null;
                Log::error("Student import error: data import");
            }
        } catch (Exception $e) {
            Log::error("Student import error: " . $e->getMessage());
        }
    }
}
