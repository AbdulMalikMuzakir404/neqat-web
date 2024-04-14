<?php

namespace App\Services\Setting;

use App\Models\Setting;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SettingService
{
    public $model;

    public function __construct(Setting $model) {
        $this->model = $model;
    }
    public function getData()
    {
        try {
            $data = $this->model->query();
            $result = $data->first();

            return $result;
        } catch (Exception $e) {
            Log::info("setting error : " . $e);

            return false;
        }
    }

    public function updateMap($data)
    {
        DB::beginTransaction();

        try {
            $map = $this->model->query();
            $map->update([
                'location_name' => $data->location_name,
                'latitude' => $data->latitude,
                'longitude' => $data->longitude,
                'radius' => $data->radius
            ]);

            DB::commit();
            return true;
        } catch (Exception $e) {
            Log::info("setting update map error : " . $e);
            DB::rollBack();
            return false;
        }
    }

    public function updateGeneral($data)
    {
        DB::beginTransaction();

        try {
            $map = $this->model->query();
            $map->update([
                'school_name' => $data->school_name,
                'school_time_from' => $data->school_time_from,
                'school_time_to' => $data->school_time_to,
                'school_hour_tolerance' => $data->school_hour_tolerance,
                'absen' => $data->absen
            ]);

            DB::commit();
            return true;
        } catch (Exception $e) {
            Log::info("setting update general error : " . $e);
            DB::rollBack();
            return false;
        }
    }
}
