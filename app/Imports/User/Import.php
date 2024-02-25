<?php

namespace App\Imports\User;

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
            $import = $this->model->create([
                'name' => $row['nama'],
                'username' => $row['username'],
                'email' => $row['email'],
                'password' => Hash::make($row['password']),
            ]);

            $role = $this->role->where('name', $row['role'])->first();

            $import->assignRole($role);

            // Simpan data user ke dalam database
            $import->save();

            if ($import) {
                return $import;
            } else {
                return false;
                Log::error("User export error: data import");
            }
        } catch (Exception $e) {
            Log::error("User export error: " . $e->getMessage());
        }
    }
}
