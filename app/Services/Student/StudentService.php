<?php

namespace App\Services\Student;

use App\Models\Role;
use App\Models\User;
use App\Services\LogActivity\LogActivityService;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class StudentService
{
    public $model, $role, $logactivity;

    public function __construct(User $model, Role $role, LogActivityService $logactivity)
    {
        $this->model = $model;
        $this->role = $role;
        $this->logactivity = $logactivity;
    }

    public function countAllDataTrash()
    {
        try {
            $data = $this->model->whereHas('roles', function ($query) {
                $query->where('name', 'student');
            });
            $data->where('is_delete', 1);
            $result = $data->count();

            return $result;
        } catch (Exception $e) {
            Log::info("student service count student error : " . $e);

            return false;
        }
    }

    public function getOneData($id)
    {
        try {
            $data = $this->model->whereHas('roles', function ($query) {
                $query->where('name', 'student');
            })
                ->where('id', $id)
                ->get();
            $result = $data->first();

            return $result;
        } catch (Exception $e) {
            Log::info("student service get student error : " . $e);

            return false;
        }
    }

    public function getAllData()
    {
        try {
            $data = $this->model->whereHas('roles', function ($query) {
                $query->where('name', 'student');
            })
                ->where('is_delete', 0)
                ->get();

            return $data;
        } catch (Exception $e) {
            Log::error("Error while getting student data: " . $e->getMessage());
            return false;
        }
    }

    public function getAllDataTrash()
    {
        try {
            $data = $this->model->whereHas('roles', function ($query) {
                $query->where('name', 'student');
            });
            $data->where('is_delete', 1);
            $result = $data->get();

            return $result;
        } catch (Exception $e) {
            Log::info("student service get student error : " . $e);

            return false;
        }
    }

    public function storeData($req)
    {
        try {
            $data = $this->model->create([
                'name' => $req->name,
                'username' => $req->username,
                'email' => $req->email,
                'password' => Hash::make($req->password),
                'created_by' => auth()->user()->id
            ]);

            $role = $this->role->where('name', 'student')->first();

            $data->assignRole($role);

            // buat sebuah log activity
            $desc = 'Membuat student ' . $data->name;
            $this->logactivity->storeData($desc);

            return [
                'data' => $data,
                'role' => $role->name
            ];
        } catch (Exception $e) {
            Log::info("student service store student error : " . $e);

            return false;
        }
    }

    public function updateData($req)
    {
        try {
            $data = $this->model->where('id', $req->dataId)->first();

            if ($req->password !== null) {
                $data->update([
                    'name' => $req->name,
                    'username' => $req->username,
                    'email' => $req->email,
                    'password' => Hash::make($req->password),
                    'updated_by' => auth()->user()->id
                ]);
            } else {
                $data->update([
                    'name' => $req->name,
                    'username' => $req->username,
                    'email' => $req->email,
                    'updated_by' => auth()->user()->name
                ]);
            }

            // Temukan atau buat peran baru
            $role = $this->role->where('name', 'student')->firstOrFail();

            // Perbarui peran pengguna
            $data->syncRoles([$role->id]);

            // buat sebuah log activity
            $desc = 'Mengubah student ' . $data->name;
            $this->logactivity->storeData($desc);

            return $data;
        } catch (Exception $e) {
            Log::info("student service store student error : " . $e);

            return false;
        }
    }

    public function updateStudentActive($req)
    {
        try {
            $data = $this->model->where('id', $req->id)->first();
            if ($data->active == true) {
                $data->update([
                    'active' => false,
                    'updated_by' => auth()->user()->id
                ]);
            } elseif ($data->active == false) {
                $data->update([
                    'active' => true,
                    'updated_by' => auth()->user()->id
                ]);
            }

            // buat sebuah log activity
            $desc = 'Mengubah student ' . $data->name;
            $this->logactivity->storeData($desc);

            return $data;
        } catch (Exception $e) {
            Log::info("student service update student active error : " . $e);

            return false;
        }
    }

    public function deleteData($req)
    {
        try {
            foreach ($req->ids as $id) {
                $data = $this->model->findOrFail($id);
                $data->update([
                    'is_delete' => true
                ]);
            }

            // buat sebuah log activity
            $desc = 'Menghapus student ' . $data->name;
            $this->logactivity->storeData($desc);

            return $data;
        } catch (Exception $e) {
            Log::info("student service delete student error : " . $e);

            return false;
        }
    }

    public function deleteDataPermanen($req)
    {
        try {
            foreach ($req->ids as $id) {
                $data = $this->model->findOrFail($id);
                $data->delete();
            }

            // buat sebuah log activity
            $desc = 'Menghapus permanen student ' . $data->name;
            $this->logactivity->storeData($desc);

            return $data;
        } catch (Exception $e) {
            Log::info("student service delete student recovery error : " . $e);

            return false;
        }
    }

    public function recoveryData($req)
    {
        try {
            foreach ($req->ids as $id) {
                $data = $this->model->findOrFail($id);
                $data->update([
                    'is_delete' => false
                ]);
            }

            // buat sebuah log activity
            $desc = 'Recovery student ' . $data->name;
            $this->logactivity->storeData($desc);

            return $data;
        } catch (Exception $e) {
            Log::info("student service recovery student error : " . $e);

            return false;
        }
    }
}
