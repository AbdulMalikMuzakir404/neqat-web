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

            $role = $this->role->where('name', $data->role)->first();

            $user->assignRole($data->role);

            return [
                'user' => $user,
                'role' => $role->name
            ];
        } catch (Exception $e) {
            Log::info("user service store user error : " . $e);

            return false;
        }
    }

    public function updateUser($data)
    {
        try {
            $user = $this->model->where('id', $data->user_id)->first();

            if ($data->password_edit !== null) {
                $user->update([
                    'name' => $data->name_edit,
                    'username' => $data->username_edit,
                    'email' => $data->email_edit,
                    'password' => Hash::make($data->password_edit)
                ]);
            } else {
                $user->update([
                    'name' => $data->name_edit,
                    'username' => $data->username_edit,
                    'email' => $data->email_edit,
                ]);
            }

            // Temukan atau buat peran baru
            $role = $this->role->where('name', $data->role_edit)->firstOrFail();

            // Perbarui peran pengguna
            $user->syncRoles([$role->id]);

            return [
                'user' => $user,
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
            $user = $this->model->where('id', $data->id)->first();
            if ($user->active == true) {
                $user->update([
                    'active' => false
                ]);
            } elseif ($user->active == false) {
                $user->update([
                    'active' => true
                ]);
            }

            $role = $user->getRoleNames()->first();

            return [
                'user' => $user,
                'role' => $role
            ];
        } catch (Exception $e) {
            Log::info("user service update user active error : " . $e);

            return false;
        }
    }

    public function deleteUser($data)
    {
        try {
            foreach ($data->ids as $id) {
                $user = $this->model->findOrFail($id);
                $user->delete();
            }

            return $user;
        } catch (Exception $e) {
            Log::info("user service store user error : " . $e);

            return false;
        }
    }
}
