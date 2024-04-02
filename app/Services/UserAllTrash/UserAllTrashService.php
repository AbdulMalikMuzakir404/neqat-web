<?php

namespace App\Services\UserAllTrash;

use App\Models\Role;
use App\Models\User;
use App\Services\LogActivity\LogActivityService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserAllTrashService
{
    public $model, $role, $logactivity;

    public function __construct(User $model, Role $role, LogActivityService $logactivity)
    {
        $this->model = $model;
        $this->role = $role;
        $this->logactivity = $logactivity;
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
            Log::info("user service get user all trash error : " . $e);

            return false;
        }
    }

    public function getAllData()
    {
        try {
            $data = $this->model->query()
                ->whereDoesntHave('roles')
                ->where('is_delete', 0)
                ->where('id', '!=', auth()->user()->id)
                ->get();


            return $data;
        } catch (Exception $e) {
            Log::error("Error while getting user all trash data: " . $e->getMessage());
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
            $desc = 'Menghapus permanen user all trash ' . $data->name;
            $this->logactivity->storeData($desc);

            return $data;
        } catch (Exception $e) {
            Log::info("user service delete user recovery error : " . $e);

            return false;
        }
    }
}
