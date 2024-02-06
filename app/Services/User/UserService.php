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

    public function getUser()
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

    public function getRoles()
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

    public function storeUser($data)
    {
        try {
            $user = $this->model->create([
                'name' => $data->name,
                'username' => $data->username,
                'email' => $data->email,
                'password' => Hash::make($data->password)
            ]);

            $user->assignRole($data->role);

            return $user;
        } catch (Exception $e) {
            Log::info("user service store user error : " . $e);

            return false;
        }
    }

    public function updateUser($data, $id)
    {
        try {
            $user = $this->model->query();
            $user->findOrFail($id);
            $user->update([
                'name' => $data->name,
                'username' => $data->username,
                'email' => $data->email,
                'password' => Hash::make($data->password)
            ]);

            if ($data->role) {
                $user->role()->associate($data->role);
            }

            return $user;
        } catch (Exception $e) {
            Log::info("user service store user error : " . $e);

            return false;
        }
    }

    public function deleteUser($id)
    {
        try {
            $user = $this->model->query();
            $user->findOrFail($id);
            $user->delete();

            return $user;
        } catch (Exception $e) {
            Log::info("user service store user error : " . $e);

            return false;
        }
    }
}
