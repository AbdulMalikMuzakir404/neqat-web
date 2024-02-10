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
        $data['data'] = $this->service->getData();

        return view('pages.announcement.index', compact('data'));
    }

    public function store(StoreAnnouncementRequest $req)
    {
        try {
            $store = $this->service->storeData($req);

            return response()->json([
                'success' => true,
                'kode' => 200,
                'data' => $store,
                'message' => 'data announcement berhasil di tambahkan'
            ], 200);
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

    public function getData(Request $req)
    {
        if ($req->ajax()) {
            $data = $this->service->getData();
            return DataTables::of($data)
                    ->addColumn('checkbox', function($user) {
                        return '<div class="custom-checkbox custom-control">
                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-'.$user->id.'">
                                    <label for="checkbox-'.$user->id.'" class="custom-control-label">&nbsp;</label>
                                </div>';
                    })
                    ->addColumn('action', function($user) {
                        return '<button class="btn btn-secondary btn-sm"><i class="ion ion-eye" data-toggle="modal" data-target="#detailUserModal-'.$user->id.'"></i></button>
                                <button class="btn btn-primary btn-sm"><i class="ion ion-compose" data-toggle="modal" data-target="#editUserModal-'.$user->id.'"></i></button>';
                    })
                    ->rawColumns(['checkbox', 'action'])
                    ->make(true);
        }

        return view('pages.announcement.index');
    }

    public function update(UpdateAnnouncementRequest $req)
    {
        try {
            $update = $this->service->updateData($req);

            return response()->json([
                'success' => true,
                'kode' => 200,
                'data' => $update,
                'message' => 'data announcement berhasil di ubah'
            ], 200);
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

            return response()->json([
                'success' => true,
                'kode' => 200,
                'data' => $delete,
                'message' => 'data announcement berhasil di hapus'
            ], 200);
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
