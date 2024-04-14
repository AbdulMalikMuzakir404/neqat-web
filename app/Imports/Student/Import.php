<?php

namespace App\Imports\Student;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Import implements ToModel, WithHeadingRow
{
    protected $model, $user, $role;

    public function __construct($model, $user, $role)
    {
        $this->model = $model;
        $this->user = $user;
        $this->role = $role;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        DB::beginTransaction();

        try {
            // Cek apakah ada pengguna dengan email atau username yang sama
            $existingUser = $this->model->with(['user', 'classroom'])->whereHas('user', function ($query) use ($row) {
                $query->where('email', $row['email'])
                    ->orWhere('username', $row['username']);
            })
                ->orWhere('nis', $row['nis'])
                ->orWhere('nisn', $row['nisn'])
                ->get();

            if ($existingUser->count() >= 1) {
                Log::info("Student export info: data import duplicate");
                DB::rollBack();
                return null;
            }

            $data = $this->user->create([
                'name' => $row['nama'],
                'username' => $row['username'],
                'email' => $row['email'],
                'password' => Hash::make($row['password']),
            ]);

            $import = $this->model->create([
                'user_id' => $data->id,
                'class_room_id' => $row['classroom'],
                'nis' => $row['nis'],
                'nisn' => $row['nisn'],
                'phone' => $row['phone'],
                'birth_date' => date('Y-m-d', strtotime($row['birthdate'])),
                'birth_place' => $row['birthplace'],
                'gender' => $row['gender'],
                'address' => $row['address'],
            ]);

            $role = $this->role->where('name', 'student')->first();

            $data->assignRole($role);

            // Simpan data student ke dalam database
            $import->save();

            if ($import) {
                DB::commit();
                return $import;
            } else {
                Log::error("Student import error: data import");
                return null;
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Student import error: " . $e->getMessage());
            return null;
        }
    }
}
