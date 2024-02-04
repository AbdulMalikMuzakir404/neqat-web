<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingGeneralRequest;
use App\Http\Requests\SettingMapRequest;
use App\Services\Setting\SettingService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    public $service;

    public function __construct(SettingService $service) {
        $this->service = $service;
    }

    public function index()
    {
        $data['setting'] = $this->service->getData();

        return view('pages.setting.index', compact('data'));
    }

    public function updateMap(SettingMapRequest $req)
    {
        try {
            $map = $this->service->updateMap($req);

            return response()->json([
                'success' => true,
                'kode' => 200,
                'data' => $map,
                'message' => 'setting map berhasil di ubah'
            ], 200);
        } catch (Exception $e) {
            Log::info("setting controller update map error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'setting controller update map error : ' . $e,
            ], 422);
        }
    }

    public function updateGeneral(SettingGeneralRequest $req)
    {
        try {
            $map = $this->service->updateGeneral($req);

            return response()->json([
                'success' => true,
                'kode' => 200,
                'data' => $map,
                'message' => 'setting general berhasil di ubah'
            ], 200);
        } catch (Exception $e) {
            Log::info("setting controller update general error : " . $e);

            return response()->json([
                'success' => false,
                'kode' => 422,
                'data' => null,
                'message' => 'setting controller update general error : ' . $e,
            ], 422);
        }
    }
}
