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
                        ->addColumn('checkbox', function($user) {
                            return '<div class="custom-checkbox custom-control text-center">
                                        <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-'.$user->id.'">
                                        <label for="checkbox-'.$user->id.'" class="custom-control-label">&nbsp;</label>
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
                    'message' => 'data announcement gagal di ambil'
                ], 400);

                return false;
            }
        }

        return view('pages.announcement.index');
    }

    public function getDataTemp()
    {
        try {
            $data = $this->service->getAllDataTemp();

            if ($data) {
                return response()->json([
                    'success' => true,
                    'kode' => 200,
                    'data' => $data,
                    'message' => 'data announcement temporary berhasil di ambil'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => $data,
                    'message' => 'data announcement temporary gagal di ambil'
                ], 400);
            }
        } catch (Exception $e) {
            Log::info("data announcement temporary controller getAllDataTrash error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'data announcement temporary controller getAllDataTrash error : ' . $e,
            ], 422);
        }
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
            $delete = $this->service->deleteData($req);

            if ($delete) {
                return response()->json([
                    'success' => true,
                    'kode' => 200,
                    'data' => $delete,
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
}
