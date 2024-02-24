<?php

namespace App\Http\Controllers\User;

use App\Exports\User\Export;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Services\User\UserService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
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
        return view('pages.user.index');
    }

    public function trash()
    {
        return view('pages.user.trash');
    }

    public function getOneData($id)
    {
        try {
            $data = $this->service->getOneData($id);

            if ($data) {
                return response()->json([
                    'success' => true,
                    'kode' => 200,
                    'data' => $data,
                    'message' => 'data one user berhasil di ambil'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data one user gagal di ambil'
                ], 400);
            }
        } catch (Exception $e) {
            Log::info("data user controller getOneData error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'data user controller getOneData error : ' . $e,
            ], 422);
        }
    }

    public function getAllRole()
    {
        try {
            $data = $this->service->getAllRole();

            if ($data) {
                return response()->json([
                    'success' => true,
                    'kode' => 200,
                    'data' => $data,
                    'message' => 'data role berhasil di ambil'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => $data,
                    'message' => 'data role gagal di ambil'
                ], 400);
            }
        } catch (Exception $e) {
            Log::info("data role controller getOneData error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'data role controller getOneData error : ' . $e,
            ], 422);
        }
    }

    public function getAllData(Request $req)
    {
        if ($req->ajax()) {
            $data = $this->service->getAllData();

            if ($data) {
                return DataTables::of($data)
                    ->addColumn('delete', function ($data) {
                        return '<div class="custom-checkbox custom-control text-center">
                                <input type="checkbox" data-checkboxes="delete" class="custom-control-input" id="checkbox-delete-' . $data->id . '">
                                <label for="checkbox-delete-' . $data->id . '" class="custom-control-label">&nbsp;</label>
                            </div>';
                    })
                    ->addColumn('export', function ($data) {
                        return '<div class="custom-checkbox custom-control text-center">
                                <input type="checkbox" data-checkboxes="export" class="custom-control-input" id="checkbox-export-' . $data->id . '">
                                <label for="checkbox-export-' . $data->id . '" class="custom-control-label">&nbsp;</label>
                            </div>';
                    })
                    ->addColumn('email_verified', function ($data) {
                        return $data->email_verified == 1 ? '<div class="badge badge-success">verified</div>' : ($data->email_verified == 0 ? '<div class="badge badge-secondary">not verified</div>' : '<div class="badge badge-danger">null</div>');
                    })
                    ->addColumn('active', function ($data) {
                        return $data->active == 1 ? '<div class="badge badge-success"><a href="#" id="active" data-id="' . $data->id . '" style="text-decoration: none; color: inherit; cursor: default">active</a></div>' : ($data->active == 0 ? '<div class="badge badge-secondary"><a href="#" id="active" data-id="' . $data->id . '" style="text-decoration: none; color: inherit; cursor: default">nonactive</a></div>' : '<div class="badge badge-danger">null</div>');
                    })
                    ->addColumn('role', function ($data) {
                        return $data->getRoleNames()->first() ?? '-';
                    })
                    ->addColumn('action', function ($data) {
                        return '<button type="button" id="detailBtn" data-id="' . $data->id . '" class="btn btn-secondary btn-sm"><i class="ion ion-eye"></i></button>
                                    <button type="button" id="editBtn" data-id="' . $data->id . '" class="btn btn-primary btn-sm"><i class="ion ion-compose"></i></button>';
                    })
                    ->rawColumns(['delete', 'export', 'email_verified', 'active', 'role', 'action'])
                    ->make(true);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data user gagal di ambil'
                ], 400);
            }
        }

        return view('pages.user.index');
    }

    public function getDataTrash()
    {
        try {
            $data = $this->service->getAllDataTrash();

            if ($data) {
                return response()->json([
                    'success' => true,
                    'kode' => 200,
                    'data' => $data,
                    'message' => 'data user trash berhasil di ambil'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => $data,
                    'message' => 'data user trash gagal di ambil'
                ], 400);
            }
        } catch (Exception $e) {
            Log::info("data user trash controller getAllDataTrash error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'data user trash controller getAllDataTrash error : ' . $e,
            ], 422);
        }
    }

    public function getAllDataTrash(Request $req)
    {
        if ($req->ajax()) {
            $data = $this->service->getAllDataTrash();

            if ($data) {
                return DataTables::of($data)
                    ->addColumn('delete', function ($data) {
                        return '<div class="custom-checkbox custom-control text-center">
                                            <input type="checkbox" data-checkboxes="delete" class="custom-control-input" id="checkbox-delete-' . $data->id . '">
                                            <label for="checkbox-delete-' . $data->id . '" class="custom-control-label">&nbsp;</label>
                                        </div>';
                    })
                    ->addColumn('recovery', function ($data) {
                        return '<div class="custom-checkbox custom-control text-center">
                                            <input type="checkbox" data-checkboxes="recovery" class="custom-control-input" id="checkbox-recovery-' . $data->id . '">
                                            <label for="checkbox-recovery-' . $data->id . '" class="custom-control-label">&nbsp;</label>
                                        </div>';
                    })
                    ->addColumn('email_verified', function ($data) {
                        return $data->email_verified == 1 ? '<div class="badge badge-success">verified</div>' : ($data->email_verified == 0 ? '<div class="badge badge-secondary">not verified</div>' : '<div class="badge badge-danger">null</div>');
                    })
                    ->addColumn('active', function ($data) {
                        return $data->active == 1 ? '<div class="badge badge-success"><a href="#" id="active" data-id="' . $data->id . '" style="text-decoration: none; color: inherit; cursor: default">active</a></div>' : ($data->active == 0 ? '<div class="badge badge-secondary"><a href="#" id="active" data-id="' . $data->id . '" style="text-decoration: none; color: inherit; cursor: default">nonactive</a></div>' : '<div class="badge badge-danger">null</div>');
                    })
                    ->addColumn('role', function ($data) {
                        return $data->getRoleNames()->first() ?? '-';
                    })
                    ->addColumn('action', function ($data) {
                        return '<button type="button" id="detailBtn" data-id="' . $data->id . '" class="btn btn-secondary btn-sm"><i class="ion ion-eye"></i></button>';
                    })
                    ->rawColumns(['delete', 'recovery', 'email_verified', 'active', 'role', 'action'])
                    ->make(true);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data user recovery gagal di ambil'
                ], 400);
            }
        }

        return view('pages.user.trash');
    }

    public function store(StoreUserRequest $req)
    {
        try {
            $data = $this->service->storeData($req);

            if ($data) {
                return response()->json([
                    'success' => true,
                    'kode' => 200,
                    'data' => $data,
                    'message' => 'data user berhasil di tambahkan'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data user gagal di tambahkan'
                ], 400);
            }
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


    public function update(UpdateUserRequest $req)
    {
        try {
            $data = $this->service->updateData($req);

            if ($data) {
                return response()->json([
                    'success' => true,
                    'kode' => 200,
                    'data' => $data,
                    'message' => 'data user berhasil di ubah'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data user gagal di ubah'
                ], 400);
            }
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
            $data = $this->service->updateUserActive($req);

            if ($data) {
                return response()->json([
                    'success' => true,
                    'kode' => 200,
                    'data' => $data,
                    'message' => 'data user active berhasil di ubah'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data user active gagal di ubah'
                ], 400);
            }
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
            $data = $this->service->deleteData($req);

            if ($data) {
                return response()->json([
                    'success' => true,
                    'kode' => 200,
                    'data' => $data,
                    'message' => 'data user berhasil di hapus'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data user gagal di hapus'
                ], 400);
            }
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

    public function destroyPermanen(Request $req)
    {
        try {
            $data = $this->service->deleteDatapermanen($req);

            if ($data) {
                return response()->json([
                    'success' => true,
                    'kode' => 200,
                    'data' => $data,
                    'message' => 'data user recovery berhasil di hapus'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data user recovery gagal di hapus'
                ], 400);
            }
        } catch (Exception $e) {
            Log::info("data user recovery controller delete error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'data user recovery controller delete error : ' . $e,
            ], 422);
        }
    }

    public function recovery(Request $req)
    {
        try {
            $data = $this->service->recoveryData($req);

            if ($data) {
                return response()->json([
                    'success' => true,
                    'kode' => 200,
                    'data' => $data,
                    'message' => 'data user berhasil di pulihkan'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data user gagal di pulihkan'
                ], 400);
            }
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

    public function export(Request $req)
    {
        try {
            $now = Carbon::now();
            $filename = 'user_' . $now->format('Y-m-d_H-i-s') . '.xlsx';
            $export = Excel::raw(new Export(new User(), $req->ids), 'Xlsx');

            // Encode file Excel menjadi base64
            $base64File = base64_encode($export);

            return response()->json([
                'success' => true,
                'kode' => 200,
                'file' => $base64File,
                'filename' => $filename,
                'message' => 'Data user berhasil diexport'
            ], 200);
        } catch (Exception $e) {
            Log::error("Data user export error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 500,
                'message' => 'Data user gagal diexport: ' . $e->getMessage(),
            ], 500);
        }
    }
}
