<?php

namespace App\Services\Temporary;

use App\Models\TemporaryFile;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class TemporaryService
{
    public $model, $tmpFileModel;

    public function __construct(TemporaryFile $model)
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
            Log::info("temporary service get temporary error : " . $e);

            return false;
        }
    }

    public function getAllData()
    {
        try {
            $data = $this->model->query();
            $result = $data->get();

            return $result;
        } catch (Exception $e) {
            Log::info("temporary service get data error : " . $e);

            return false;
        }
    }

    public function deleteData($req)
    {
        try {
            foreach ($req->ids as $id) {
                $data = $this->model->findOrFail($id);

                // Menghapus gambar terkait jika ada
                if ($data->filename) {
                    $imagePath = public_path('orders/temp/' . $data->folder);
                    if (File::exists($imagePath)) {
                        File::deleteDirectory($imagePath); // Menghapus direktori beserta isinya
                    }
                }

                $data->delete();
            }

            return true;
        } catch (Exception $e) {
            Log::info("temporary service delete data error : " . $e);

            return false;
        }
    }
}
