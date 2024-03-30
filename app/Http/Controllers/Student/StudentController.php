<?php

namespace App\Http\Controllers\Student;

use App\Exports\Student\Export;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\ImportRequest;
use App\Http\Requests\Student\StoreStudentRequest;
use App\Http\Requests\Student\UpdateStudentRequest;
use App\Imports\Student\Import;
use App\Models\Role;
use App\Models\User;
use App\Services\LogActivity\LogActivityService;
use App\Services\Student\StudentService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    public $service, $logactivity;

    public function __construct(StudentService $service, LogActivityService $logactivity)
    {
        $this->service = $service;
        $this->logactivity = $logactivity;
    }

    public function index()
    {
        return view('pages.student.index');
    }

    public function trash()
    {
        return view('pages.student.trash');
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
                    'message' => 'data student count trash berhasil di ambil'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 200,
                    'data' => $data,
                    'message' => 'data student count trash kosong'
                ], 200);
            }
        } catch (Exception $e) {
            Log::info("data student trash controller getAllDataTrash error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'data student trash controller getAllDataTrash error : ' . $e,
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
                    'message' => 'data one student berhasil di ambil'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data one student gagal di ambil'
                ], 400);
            }
        } catch (Exception $e) {
            Log::info("data student controller getOneData error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'data student controller getOneData error : ' . $e,
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
                    ->addColumn('action', function ($data) {
                        return '<button type="button" id="detailBtn" data-id="' . $data->id . '" class="btn btn-secondary btn-sm"><i class="ion ion-eye"></i></button>
                                    <button type="button" id="editBtn" data-id="' . $data->id . '" class="btn btn-primary btn-sm"><i class="ion ion-compose"></i></button>';
                    })
                    ->rawColumns(['delete', 'export', 'email_verified', 'active', 'action'])
                    ->make(true);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data student gagal di ambil'
                ], 400);
            }
        }

        return view('pages.student.index');
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
                        return '<div class="text-center">
                                    <button type="button" id="detailBtn" data-id="'. $data->id .'" class="btn btn-secondary btn-sm"><i class="ion ion-eye"></i></button>
                                </div>';
                    })
                    ->rawColumns(['delete', 'recovery', 'email_verified', 'active', 'role', 'action'])
                    ->make(true);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data student recovery gagal di ambil'
                ], 400);
            }
        }

        return view('pages.student.trash');
    }

    public function store(StoreStudentRequest $req)
    {
        try {
            $data = $this->service->storeData($req);

            if ($data) {
                return response()->json([
                    'success' => true,
                    'kode' => 200,
                    'data' => $data,
                    'message' => 'data student berhasil di tambahkan'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data student gagal di tambahkan'
                ], 400);
            }
        } catch (Exception $e) {
            Log::info("data student controller store error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'data student controller store error : ' . $e,
            ], 422);
        }
    }

    public function update(UpdateStudentRequest $req)
    {
        try {
            $data = $this->service->updateData($req);

            if ($data) {
                return response()->json([
                    'success' => true,
                    'kode' => 200,
                    'data' => $data,
                    'message' => 'data student berhasil di ubah'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data student gagal di ubah'
                ], 400);
            }
        } catch (Exception $e) {
            Log::info("data student controller update error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'data student controller update error : ' . $e,
            ], 422);
        }
    }

    public function updateActive(Request $req)
    {
        try {
            $data = $this->service->updateStudentActive($req);

            if ($data) {
                return response()->json([
                    'success' => true,
                    'kode' => 200,
                    'data' => $data,
                    'message' => 'data student active berhasil di ubah'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data student active gagal di ubah'
                ], 400);
            }
        } catch (Exception $e) {
            Log::info("data student controller update active error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'data student controller update active error : ' . $e,
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
                    'message' => 'data student berhasil di hapus'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data student gagal di hapus'
                ], 400);
            }
        } catch (Exception $e) {
            Log::info("data student controller delete error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'data student controller delete error : ' . $e,
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
                    'message' => 'data student trash berhasil di hapus'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data student trash gagal di hapus'
                ], 400);
            }
        } catch (Exception $e) {
            Log::info("data student trash controller delete error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'data student trash controller delete error : ' . $e,
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
                    'message' => 'data student berhasil di pulihkan'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'data student gagal di pulihkan'
                ], 400);
            }
        } catch (Exception $e) {
            Log::info("data student controller delete error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'data student controller delete error : ' . $e,
            ], 422);
        }
    }

    public function import(ImportRequest $req)
    {
        // Ambil file yang diunggah
        $file = $req->file('file');

        if (!$file) {
            return response()->json([
                'success' => false,
                'kode' => 400,
                'data' => null,
                'message' => 'File tidak ditemukan'
            ], 400);
        }

        try {
            // Import data dari file Excel
            $import = new Import(new User(), new Role());
            $excel = Excel::import($import, $file);

            if ($excel) {
                // buat sebuah log activity
                $desc = 'Melakukan import data student';
                $this->logactivity->storeData($desc);

                return response()->json([
                    'success' => true,
                    'kode' => 200,
                    'data' => null,
                    'message' => 'Data student berhasil di import'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'message' => 'Data student gagal di import'
                ], 400);
            }
        } catch (Exception $e) {
            Log::error("Data student import error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 500,
                'message' => 'Data student gagal di import: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function export(Request $req)
    {
        try {
            $now = Carbon::now();
            $filename = 'student_' . $now->format('Y-m-d_H-i-s') . '.xlsx';
            $export = Excel::raw(new Export(new User(), $req->ids), 'Xlsx');

            // Encode file Excel menjadi base64
            $base64File = base64_encode($export);

            if ($export) {
                // buat sebuah log activity
                $desc = 'Melakukan export data student';
                $this->logactivity->storeData($desc);

                return response()->json([
                    'success' => true,
                    'kode' => 200,
                    'file' => $base64File,
                    'filename' => $filename,
                    'message' => 'Data student berhasil di export'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'file' => null,
                    'filename' => null,
                    'message' => 'Data student gagal di export'
                ], 400);
            }
        } catch (Exception $e) {
            Log::error("Data student export error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 500,
                'message' => 'Data student gagal di export: ' . $e->getMessage(),
            ], 500);
        }
    }
}
