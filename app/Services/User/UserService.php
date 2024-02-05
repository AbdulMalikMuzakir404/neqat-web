<?php

namespace App\Services\User;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;

class UserService
{
    public $model;

    public function __construct(User $model) {
        $this->model = $model;
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
            Log::info("user serive get user error : " . $e);

            return false;
        }
    }
}
