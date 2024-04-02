<?php

namespace App\Http\Controllers\UserAllTrash;

use App\Http\Controllers\Controller;
use App\Services\LogActivity\LogActivityService;
use App\Services\UserAllTrash\UserAllTrashService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class UserAllTrashController extends Controller
{
    public $service, $logactivity;

    public function __construct(UserAllTrashService $service, LogActivityService $logactivity)
    {
        $this->service = $service;
        $this->logactivity = $logactivity;
    }

    public function index()
    {
        return view('pages.useralltrash.index');
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
                    'message' => 'data one user all trash berhasil di ambil'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data one user all trash gagal di ambil'
                ], 400);
            }
        } catch (Exception $e) {
            Log::info("data user all trash controller getOneData error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'data user all trash controller getOneData error : ' . $e,
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
                    ->rawColumns(['delete', 'email_verified', 'active', 'role', 'action'])
                    ->make(true);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data user all trash gagal di ambil'
                ], 400);
            }
        }

        return view('pages.useralltrash.index');
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
                    'message' => 'data user all trash berhasil di hapus'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data user all trash gagal di hapus'
                ], 400);
            }
        } catch (Exception $e) {
            Log::info("data user all trash controller delete error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'data user all trash controller delete error : ' . $e,
            ], 422);
        }
    }
}
