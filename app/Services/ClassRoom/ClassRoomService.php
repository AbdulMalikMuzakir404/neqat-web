<?php

namespace App\Services\ClassRoom;

use App\Models\ClassRoom;
use Exception;
use Illuminate\Support\Facades\Log;

class ClassRoomService
{
    public $model;

    public function __construct(ClassRoom $model)
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
            Log::info("classroom service get classroom error : " . $e);

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
            Log::info("classroom service get data error : " . $e);

            return false;
        }
    }

    public function storeData($req)
    {
        try {
            $data = $this->model->create([
                'name' => $req->name,
            ]);
            $result = $data->save();

            return $result;
        } catch (Exception $e) {
            Log::info("classroom service store data error : " . $e);

            return false;
        }
    }

    public function updateData($req)
    {
        try {
            $data = $this->model->where('id', $req->dataId)->first();

            $result = $data->update([
                'name' => $req->name,
            ]);

            return $result;
        } catch (Exception $e) {
            Log::info("announcement service store data error : " . $e);

            return false;
        }
    }

    public function deleteData($req)
    {
        try {
            foreach ($req->ids as $id) {
                $data = $this->model->findOrFail($id);

                // Menghapus gambar terkait jika ada
                if ($data->image) {
                    $imagePath = public_path('file/announcement/' . $data->id);
                    if (File::exists($imagePath)) {
                        File::deleteDirectory($imagePath); // Menghapus direktori beserta isinya
                    }
                }

                $data->delete();
            }

            return true;
        } catch (Exception $e) {
            Log::info("announcement service delete data error : " . $e);

            return false;
        }
    }
}
