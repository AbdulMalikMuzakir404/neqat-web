<?php

namespace App\Http\Controllers\LogActivity;

use App\Exports\LogActivity\Export;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreLogActivityRequest;
use App\Models\LogActivity;
use App\Services\LogActivity\LogActivityService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class LogActivityController extends Controller
{
    public $service;

    public function __construct(LogActivityService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('pages.logactivity.index');
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
                    ->rawColumns(['delete'])
                    ->make(true);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data log gagal di ambil'
                ], 400);
            }
        }

        return view('pages.logactivity.index');
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
                    'message' => 'Data log activity berhasil di hapus'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'Data log activity gagal di hapus'
                ], 400);
            }
        } catch (Exception $e) {
            Log::info("Data log activity controller delete error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'Data log activity controller delete error : ' . $e,
            ], 422);
        }
    }

    public function exportAndDelete(Request $req)
    {
        try {
            $now = Carbon::now();
            $filename = 'logactivity_' . $now->format('Y-m-d_H-i-s') . '.xlsx';
            $export = Excel::raw(new Export(new LogActivity(), $req->ids), 'Xlsx');

            // Encode file Excel menjadi base64
            $base64File = base64_encode($export);

            if ($export) {
                $this->destroy($req);
                return response()->json([
                    'success' => true,
                    'kode' => 200,
                    'file' => $base64File,
                    'filename' => $filename,
                    'message' => 'Data log activity berhasil di export'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'file' => null,
                    'filename' => null,
                    'message' => 'Data log activity gagal di export'
                ], 400);
            }
        } catch (Exception $e) {
            Log::error("Data log activity export error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 500,
                'message' => 'Data log activity gagal di export: ' . $e->getMessage(),
            ], 500);
        }
    }
}
