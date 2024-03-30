<?php

namespace App\Http\Controllers\ClassRoom;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClassRoom\StoreClassRoomRequest;
use App\Http\Requests\ClassRoom\UpdateClassRoomRequest;
use App\Services\ClassRoom\ClassRoomService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class ClassRoomController extends Controller
{
    public $service;

    public function __construct(ClassRoomService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('pages.classroom.index');
    }

    public function trash()
    {
        return view('pages.classroom.trash');
    }

    public function countDataTrash()
    {
        try {
            $data = $this->service->countAllDataTrash();

            if ($data) {
                return response()->json([
                    'success' => true,
                    'kode' => 200,
                    'data' => $data,
                    'message' => 'data classroom count trash berhasil di ambil'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 200,
                    'data' => $data,
                    'message' => 'data classroom count trash kosong'
                ], 200);
            }
        } catch (Exception $e) {
            Log::info("data classroom trash controller getAllDataTrash error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'data classroom trash controller getAllDataTrash error : ' . $e,
            ], 422);
        }
    }

    public function store(StoreClassRoomRequest $req)
    {
        try {
            $store = $this->service->storeData($req);

            if ($store) {
                return response()->json([
                    'success' => true,
                    'kode' => 200,
                    'data' => $store,
                    'message' => 'data classroom berhasil di tambahkan'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data classroom gagal di tambahkan'
                ], 400);
            }
        } catch (Exception $e) {
            Log::info("data classroom controller store error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'data classroom controller store error : ' . $e,
            ], 422);
        }
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
                    'message' => 'data one classroom berhasil di ambil'
                ], 200);
            } else {
                return response()->json([
                    'success' => true,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data one classroom gagal di ambil'
                ], 400);
            }
        } catch (Exception $e) {
            Log::info("data user controller getOneData error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'data classroom controller getOneData error : ' . $e,
            ], 422);
        }
    }

    public function getAllData(Request $req)
    {
        if ($req->ajax()) {
            $data = $this->service->getAllData();

            if ($data) {
                return DataTables::of($data)
                        ->addColumn('checkbox', function($data) {
                            return '<div class="custom-checkbox custom-control text-center">
                                        <input type="checkbox" data-checkboxes="delete" class="custom-control-input" id="checkbox-'.$data->id.'">
                                        <label for="checkbox-'.$data->id.'" class="custom-control-label">&nbsp;</label>
                                    </div>';
                        })
                        ->addColumn('action', function($data) {
                            return '<div class="text-center">
                                        <button type="button" id="detailBtn" data-id="'. $data->id .'" class="btn btn-secondary btn-sm"><i class="ion ion-eye"></i></button>
                                        <button type="button" id="editBtn" data-id="'. $data->id .'" class="btn btn-primary btn-sm"><i class="ion ion-compose"></i></button>
                                    </div>';
                        })
                        ->rawColumns(['checkbox', 'action'])
                        ->make(true);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data classroom gagal di ambil'
                ], 400);

                return false;
            }
        }

        return view('pages.classroom.index');
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
                    ->addColumn('action', function($data) {
                        return '<div class="text-center">
                                    <button type="button" id="detailBtn" data-id="'. $data->id .'" class="btn btn-secondary btn-sm"><i class="ion ion-eye"></i></button>
                                </div>';
                    })
                    ->rawColumns(['delete', 'recovery', 'action'])
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

        return view('pages.classroom.trash');
    }

    public function update(UpdateClassRoomRequest $req)
    {
        try {
            $update = $this->service->updateData($req);

            if ($update) {
                return response()->json([
                    'success' => true,
                    'kode' => 200,
                    'data' => $update,
                    'message' => 'data classroom berhasil di ubah'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data classroom gagal di ubah'
                ], 400);
            }
        } catch (Exception $e) {
            Log::info("data classroom controller update error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'data classroom controller update error : ' . $e,
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
                    'message' => 'data classroom berhasil di hapus'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data classroom gagal di hapus'
                ], 400);
            }
        } catch (Exception $e) {
            Log::info("data classroom controller delete error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'data classroom controller delete error : ' . $e,
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
                    'message' => 'data classroom trash berhasil di hapus'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data classroom trash gagal di hapus'
                ], 400);
            }
        } catch (Exception $e) {
            Log::info("data classroom trash controller delete error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'data classroom trash controller delete error : ' . $e,
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
}
