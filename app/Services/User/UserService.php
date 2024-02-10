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
            $users = $this->model->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'student');
            });
            $users->where('id', '!=', auth()->user()->id);
            $result = $users->get();

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

    public function updateUserActive($data)
    {
        try {
            $data = $this->model->where('id', $data->id)->first();
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

    public function deleteData($data)
    {
        try {
            foreach ($data->ids as $id) {
                $data = $this->model->findOrFail($id);
                $data->delete();
            }

            return $data;
        } catch (Exception $e) {
            Log::info("user service delete user error : " . $e);

            return false;
        }
    }
}
