<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\User\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

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

    public function getUser(Request $req)
    {
        if ($req->ajax()) {
            $data = $this->service->getUser();
            return DataTables::of($data)
                    ->addColumn('checkbox', function($user) {
                        return '<div class="custom-checkbox custom-control">
                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-'.$user->id.'">
                                    <label for="checkbox-'.$user->id.'" class="custom-control-label">&nbsp;</label>
                                </div>';
                    })
                    ->addColumn('email_verified', function($user) {
                        return $user->email_verified == 1 ? '<div class="badge badge-success">verified</div>' : ($user->email_verified == 0 ? '<div class="badge badge-secondary">not verified</div>' : '<div class="badge badge-danger">null</div>');
                    })
                    ->addColumn('active', function($user) {
                        return $user->active == 1 ? '<div class="badge badge-success"><a href="#" id="active" data-id="'.$user->id.'" style="text-decoration: none; color: inherit; cursor: default">active</a></div>' : ($user->active == 0 ? '<div class="badge badge-secondary"><a href="#" id="active" data-id="'.$user->id.'" style="text-decoration: none; color: inherit; cursor: default">nonactive</a></div>' : '<div class="badge badge-danger">null</div>');
                    })
                    ->addColumn('role', function($user) {
                        return $user->getRoleNames()->first() ?? '-';
                    })
                    ->addColumn('action', function($user) {
                        return '<button class="btn btn-secondary btn-sm"><i class="ion ion-eye" data-toggle="modal" data-target="#detailUserModal-'.$user->id.'"></i></button>
                                <button class="btn btn-primary btn-sm"><i class="ion ion-compose" data-toggle="modal" data-target="#editUserModal-'.$user->id.'"></i></button>';
                    })
                    ->rawColumns(['checkbox', 'email_verified', 'active', 'role', 'action'])
                    ->make(true);
        }

        return view('pages.user.index');
    }

    public function update(UpdateUserRequest $req)
    {
        try {
            $user = $this->service->updateUser($req);

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

    public function updateActive(Request $req)
    {
        try {
            $user = $this->service->updateUserActive($req);

            return response()->json([
                'success' => true,
                'kode' => 200,
                'data' => $user,
                'message' => 'data user active berhasil di ubah'
            ], 200);
        } catch (Exception $e) {
            Log::info("data user controller update active error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'data user controller update active error : ' . $e,
            ], 422);
        }
    }

    public function destroy(Request $req)
    {
        try {
            $user = $this->service->deleteUser($req);

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
