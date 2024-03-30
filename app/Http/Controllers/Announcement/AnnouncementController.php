<?php

namespace App\Http\Controllers\Announcement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Announcement\StoreAnnouncementRequest;
use App\Http\Requests\Announcement\UpdateAnnouncementRequest;
use App\Services\Announcement\AnnouncementService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class AnnouncementController extends Controller
{
    public $service;

    public function __construct(AnnouncementService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('pages.announcement.index');
    }

    public function trash()
    {
        return view('pages.announcement.trash');
    }

    public function countDataTrash()
    {
        try {
            $data = $this->service->countAllDataTrash();

            if ($data >= 1) {
                return response()->json([
                    'success' => true,
                    'kode' => 200,
                    'data' => $data,
                    'message' => 'data announcement count trash berhasil di ambil'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 200,
                    'data' => $data,
                    'message' => 'data announcement count trash kosong'
                ], 200);
            }
        } catch (Exception $e) {
            Log::info("data announcement count trash controller countAllDataTrash error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'data announcement count trash controller countAllDataTrash error : ' . $e,
            ], 422);
        }
    }

    public function countDataTemp()
    {
        try {
            $data = $this->service->countAllDataTemp();

            if ($data >= 1) {
                return response()->json([
                    'success' => true,
                    'kode' => 200,
                    'data' => $data,
                    'message' => 'data announcement count temporary berhasil di ambil'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 200,
                    'data' => $data,
                    'message' => 'data announcement count temporary kosong'
                ], 200);
            }
        } catch (Exception $e) {
            Log::info("data announcement count temporary controller countAllDataTrash error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'data announcement count temporary controller countAllDataTrash error : ' . $e,
            ], 422);
        }
    }

    public function store(StoreAnnouncementRequest $req)
    {
        try {
            $store = $this->service->storeData($req);

            if ($store) {
                return response()->json([
                    'success' => true,
                    'kode' => 200,
                    'data' => $store,
                    'message' => 'data announcement berhasil di tambahkan'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data announcement gagal di tambahkan'
                ], 400);
            }
        } catch (Exception $e) {
            Log::info("data announcement controller store error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'data announcement controller store error : ' . $e,
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
                    'message' => 'data one announcement berhasil di ambil'
                ], 200);
            } else {
                return response()->json([
                    'success' => true,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data one announcement gagal di ambil'
                ], 400);
            }
        } catch (Exception $e) {
            Log::info("data user controller getOneData error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'data announcement controller getOneData error : ' . $e,
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
                                        <input type="checkbox" data-checkboxes="delete" class="custom-control-input" id="checkbox-' . $data->id . '">
                                        <label for="checkbox-' . $data->id . '" class="custom-control-label">&nbsp;</label>
                                    </div>';
                    })
                    ->addColumn('action', function ($data) {
                        return '<div class="text-center">
                                        <button type="button" id="detailBtn" data-id="' . $data->id . '" class="btn btn-secondary btn-sm"><i class="ion ion-eye"></i></button>
                                        <button type="button" id="editBtn" data-id="' . $data->id . '" class="btn btn-primary btn-sm"><i class="ion ion-compose"></i></button>
                                    </div>';
                    })
                    ->rawColumns(['delete', 'action'])
                    ->make(true);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data announcement gagal di ambil'
                ], 400);

                return false;
            }
        }

        return view('pages.announcement.index');
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
                    ->addColumn('action', function ($data) {
                        return '<div class="text-center">
                                        <button type="button" id="detailBtn" data-id="' . $data->id . '" class="btn btn-secondary btn-sm"><i class="ion ion-eye"></i></button>
                                    </div>';
                    })
                    ->rawColumns(['delete', 'recovery', 'action'])
                    ->make(true);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data announcement gagal di ambil'
                ], 400);

                return false;
            }
        }

        return view('pages.announcement.trash');
    }

    public function update(UpdateAnnouncementRequest $req)
    {
        try {
            $update = $this->service->updateData($req);

            if ($update) {
                return response()->json([
                    'success' => true,
                    'kode' => 200,
                    'data' => $update,
                    'message' => 'data announcement berhasil di ubah'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data announcement gagal di ubah'
                ], 400);
            }
        } catch (Exception $e) {
            Log::info("data announcement controller update error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'data announcement controller update error : ' . $e,
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
                    'message' => 'data announcement berhasil di hapus'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data announcement gagal di hapus'
                ], 400);
            }
        } catch (Exception $e) {
            Log::info("data announcement controller delete error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'data announcement controller delete error : ' . $e,
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
                    'message' => 'data announcement trash berhasil di hapus'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data announcement trash gagal di hapus'
                ], 400);
            }
        } catch (Exception $e) {
            Log::info("data announcement trash controller delete error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'data announcement trash controller delete error : ' . $e,
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
                    'message' => 'data announcement berhasil di pulihkan'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data announcement gagal di pulihkan'
                ], 400);
            }
        } catch (Exception $e) {
            Log::info("data announcement controller delete error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'data announcement controller delete error : ' . $e,
            ], 422);
        }
    }
}
