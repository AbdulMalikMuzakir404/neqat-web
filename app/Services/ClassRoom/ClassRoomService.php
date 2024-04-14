<?php

namespace App\Services\ClassRoom;

use App\Models\ClassRoom;
use App\Services\LogActivity\LogActivityService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClassRoomService
{
    public $model, $logactivity;

    public function __construct(ClassRoom $model, LogActivityService $logactivity)
    {
        $this->model = $model;
        $this->logactivity = $logactivity;
    }

    public function countAllDataTrash()
    {
        try {
            $data = $this->model->query();
            $data->where('is_delete', 1);
            $result = $data->count();

            return $result;
        } catch (Exception $e) {
            Log::info("classroom service count classroom trash error : " . $e);

            return false;
        }
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
            $data->where('is_delete', 0);
            $result = $data->get();

            return $result;
        } catch (Exception $e) {
            Log::info("classroom service get data error : " . $e);

            return false;
        }
    }

    public function getAllDataTrash()
    {
        try {
            $data = $this->model->query();
            $data->where('is_delete', 1);
            $result = $data->get();

            return $result;
        } catch (Exception $e) {
            Log::info("classroom service get classroom trash error : " . $e);

            return false;
        }
    }

    public function storeData($req)
    {
        DB::beginTransaction();

        try {
            $data = $this->model->create([
                'classname' => $req->classname,
                'major' => $req->major,
            ]);
            $result = $data->save();

            // buat sebuah log activity
            $desc = 'Membuat classroom ' . $data->classname . ' ' . $data->major;
            $this->logactivity->storeData($desc);

            DB::commit();
            return $result;
        } catch (Exception $e) {
            Log::info("classroom service store data error : " . $e);
            db::rollBack();
            return false;
        }
    }

    public function updateData($req)
    {
        DB::beginTransaction();
        try {
            $data = $this->model->where('id', $req->dataId)->first();

            $result = $data->update([
                'classname' => $req->classname,
                'major' => $req->major,
            ]);

            // buat sebuah log activity
            $desc = 'Mengubah classroom ' . $data->classname . ' ' . $data->major;
            $this->logactivity->storeData($desc);

            DB::commit();
            return $result;
        } catch (Exception $e) {
            Log::info("classroom service store data error : " . $e);
            DB::rollBack();
            return false;
        }
    }

    public function deleteData($req)
    {
        DB::beginTransaction();

        try {
            foreach ($req->ids as $id) {
                $data = $this->model->with(['student.user'])->findOrFail($id);

                if ($data->student || $data->student->user) {
                    DB::rollBack();
                    return false;
                } else {
                    $data->update([
                        'is_delete' => true
                    ]);
                }
            }

            // buat sebuah log activity
            $desc = 'Menghapus classroom ' . $data->name;
            $this->logactivity->storeData($desc);

            DB::commit();
            return $data;
        } catch (Exception $e) {
            Log::info("classroom service delete classeoom error : " . $e);
            DB::rollBack();
            return false;
        }
    }

    public function deleteDataPermanen($req)
    {
        DB::beginTransaction();

        try {
            foreach ($req->ids as $id) {
                $data = $this->model->with(['student.user'])->findOrFail($id);

                if ($data->student || $data->student->user) {
                    DB::rollBack();
                    return false;
                } else {
                    $data->delete();
                }
            }

            // buat sebuah log activity
            $desc = 'Menghapus permanen classroom ' . $data->name;
            $this->logactivity->storeData($desc);

            DB::commit();
            return $data;
        } catch (Exception $e) {
            Log::info("classroom service delete classroom recovery error : " . $e);
            DB::rollBack();
            return false;
        }
    }

    public function recoveryData($req)
    {
        DB::beginTransaction();

        try {
            foreach ($req->ids as $id) {
                $data = $this->model->findOrFail($id);
                $data->update([
                    'is_delete' => false
                ]);
            }

            // buat sebuah log activity
            $desc = 'Recovery classroom ' . $data->name;
            $this->logactivity->storeData($desc);

            DB::commit();
            return $data;
        } catch (Exception $e) {
            Log::info("classroom service recovery classroom error : " . $e);
            DB::rollBack();
            return false;
        }
    }
}
