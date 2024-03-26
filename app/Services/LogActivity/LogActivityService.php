<?php

namespace App\Services\LogActivity;

use App\Models\LogActivity;
use Exception;
use Illuminate\Support\Facades\Log;

class LogActivityService
{
    public $model;

    public function __construct(LogActivity $model)
    {
        $this->model = $model;
    }

    public function getOneData($id)
    {
        try {
            $data = $this->model->query();
            $data->where('id', $id);
            $result = $data->first();

            return $result;
        } catch (Exception $e) {
            Log::info("log service get one data error : " . $e);

            return false;
        }
    }

    public function getAllData()
    {
        try {
            $data = $this->model->query();
            $data->with(['user']);
            $result = $data->get();

            return $result;
        } catch (Exception $e) {
            Log::info("log service get data error : " . $e);

            return false;
        }
    }

    public function storeData($desc)
    {
        try {
            $data = $this->model->create([
                'user_id' => auth()->user()->id,
                'description' => $desc
            ]);

            return $data;
        } catch (Exception $e) {
            Log::info("log service store data error : " . $e);

            return false;
        }
    }

    public function deleteData($req)
    {
        try {
            foreach ($req->ids as $id) {
                $data = $this->model->findOrFail($id);
                $data->delete();
            }

            return true;
        } catch (Exception $e) {
            Log::info("log service delete data error : " . $e);

            return false;
        }
    }
}
