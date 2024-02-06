<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\User\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $data['users'] = $this->service->getUser();
        $data['roles'] = $this->service->getRoles();

        return view('pages.user.index', compact('data'));
    }

    public function store(StoreUserRequest $req)
    {
        try {
            $user = $this->service->storeUser($req);

            return response()->json([
                'success' => true,
                'kode' => 200,
                'data' => $user,
                'message' => 'data user berhasil di tambahkan'
            ], 200);
        } catch (Exception $e) {
            Log::info("data user controller store error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'data user controller store error : ' . $e,
            ], 422);
        }
    }

    public function update(UpdateUserRequest $req, $id)
    {
        try {
            $user = $this->service->updateUser($req, $id);

            return response()->json([
                'success' => true,
                'kode' => 200,
                'data' => $user,
                'message' => 'data user berhasil di ubah'
            ], 200);
        } catch (Exception $e) {
            Log::info("data user controller update error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'data user controller update error : ' . $e,
            ], 422);
        }
    }

    public function destroy($id)
    {
        try {
            $user = $this->service->deleteUser($id);

            return response()->json([
                'success' => true,
                'kode' => 200,
                'data' => $user,
                'message' => 'data user berhasil di hapus'
            ], 200);
        } catch (Exception $e) {
            Log::info("data user controller delete error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'data user controller delete error : ' . $e,
            ], 422);
        }
    }
}
