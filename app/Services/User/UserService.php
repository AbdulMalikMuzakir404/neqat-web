<?php

namespace App\Services\User;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class UserService
{
    public $model, $role;

    public function __construct(User $model, Role $role)
    {
        $this->model = $model;
        $this->role = $role;
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
            $roles = $this->role->where('name', '!=', 'student');
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
            });
            $data->where('is_delete', 0);
            $data->where('id', '!=', auth()->user()->id);
            $result = $data->get();

            return $result;
        } catch (Exception $e) {
            Log::info("user service get user error : " . $e);

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
                'password' => Hash::make($req->password)
            ]);

            $role = $this->role->where('id', $req->role)->first();

            $data->assignRole($role);

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
                    'password' => Hash::make($req->password)
                ]);
            } else {
                $data->update([
                    'name' => $req->name,
                    'username' => $req->username,
                    'email' => $req->email,
                ]);
            }

            // Temukan atau buat peran baru
            $role = $this->role->where('id', $req->role)->firstOrFail();

            // Perbarui peran pengguna
            $data->syncRoles([$role->id]);

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
                    'active' => false
                ]);
            } elseif ($data->active == false) {
                $data->update([
                    'active' => true
                ]);
            }

            $role = $data->getRoleNames()->first();

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

            return $data;
        } catch (Exception $e) {
            Log::info("user service recovery user error : " . $e);

            return false;
        }
    }
}
