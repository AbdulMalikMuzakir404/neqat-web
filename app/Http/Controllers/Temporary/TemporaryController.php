<?php

namespace App\Http\Controllers\Temporary;

use App\Http\Controllers\Controller;
use App\Services\Temporary\TemporaryService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class TemporaryController extends Controller
{
    public $service;

    public function __construct(TemporaryService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('pages.temporary.index');
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
                    'message' => 'data one temporary berhasil di ambil'
                ], 200);
            } else {
                return response()->json([
                    'success' => true,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data one temporary gagal di ambil'
                ], 400);
            }
        } catch (Exception $e) {
            Log::info("data user controller getOneData error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'data temporary controller getOneData error : ' . $e,
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
                            return '<button type="button" id="detailBtn" data-id="'. $data->id .'" class="btn btn-secondary btn-sm"><i class="ion ion-eye"></i></button>';
                        })
                        ->rawColumns(['checkbox', 'action'])
                        ->make(true);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data temporary gagal di ambil'
                ], 400);

                return false;
            }
        }

        return view('pages.temporary.index');
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
                    'message' => 'data temporary berhasil di hapus'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data temporary gagal di hapus'
                ], 400);
            }
        } catch (Exception $e) {
            Log::info("data temporary controller delete error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'data temporary controller delete error : ' . $e,
            ], 422);
        }
    }
}
