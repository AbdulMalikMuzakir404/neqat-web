<?php

namespace App\Services\User;

use App\Models\Role;
use App\Models\User;
use App\Services\LogActivity\LogActivityService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserService
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
            $data = $this->model->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'student');
            });
            $data->where('is_delete', 1);
            $data->where('id', '!=', auth()->user()->id);
            $result = $data->count();

            return $result;
        } catch (Exception $e) {
            Log::info("user service count user error : " . $e);

            return false;
        }
    }

    public function getOneData($id)
    {
        try {
            $data = $this->model->query();
            $data->where('id', $id);
            $result = $data->first();

            $role = $result->getRoleNames()->first();

            return [
                'data' => $result,
                'role' => $role
            ];
        } catch (Exception $e) {
            Log::info("user service get user error : " . $e);

            return false;
        }
    }

    public function getAllRole()
    {
        try {
            $roles = $this->role->whereNotIn('name', ['student', 'developer']);
            $result = $roles->get();

            return $result;
        } catch (Exception $e) {
            Log::info("user service get roles error : " . $e);

            return false;
        }
    }

    public function getAllData()
    {
        try {
            $data = $this->model->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'student');
                $query->orWhere('name', 'developer');
            })
                ->where('is_delete', 0)
                ->where('id', '!=', auth()->user()->id)
                ->get();


            return $data;
        } catch (Exception $e) {
            Log::error("Error while getting user data: " . $e->getMessage());
            return false;
        }
    }

    public function getAllDataTrash()
    {
        try {
            $data = $this->model->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'student');
            });
            $data->where('is_delete', 1);
            $data->where('id', '!=', auth()->user()->id);
            $result = $data->get();

            return $result;
        } catch (Exception $e) {
            Log::info("user service get user error : " . $e);

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

            $role = $this->role->where('id', $req->role)->first();

            $data->assignRole($role);

            // buat sebuah log activity
            $desc = 'Membuat user ' . $data->name;
            $this->logactivity->storeData($desc);

            return [
                'data' => $data,
                'role' => $role->name
            ];
        } catch (Exception $e) {
            Log::info("user service store user error : " . $e);

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
            $role = $this->role->where('id', $req->role)->firstOrFail();

            // Perbarui peran pengguna
            $data->syncRoles([$role->id]);

            // buat sebuah log activity
            $desc = 'Mengubah user ' . $data->name;
            $this->logactivity->storeData($desc);

            return [
                'data' => $data,
                'role' => $role->name
            ];
        } catch (Exception $e) {
            Log::info("user service store user error : " . $e);

            return false;
        }
    }

    public function updateUserActive($req)
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

            $role = $data->getRoleNames()->first();

            // buat sebuah log activity
            $desc = 'Mengubah user ' . $data->name;
            $this->logactivity->storeData($desc);

            return [
                'data' => $data,
                'role' => $role
            ];
        } catch (Exception $e) {
            Log::info("user service update user active error : " . $e);

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
            $desc = 'Menghapus user ' . $data->name;
            $this->logactivity->storeData($desc);

            return $data;
        } catch (Exception $e) {
            Log::info("user service delete user error : " . $e);

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
            $desc = 'Menghapus permanen user ' . $data->name;
            $this->logactivity->storeData($desc);

            return $data;
        } catch (Exception $e) {
            Log::info("user service delete user recovery error : " . $e);

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
            $desc = 'Recovery user ' . $data->name;
            $this->logactivity->storeData($desc);

            return $data;
        } catch (Exception $e) {
            Log::info("user service recovery user error : " . $e);

            return false;
        }
    }
}
