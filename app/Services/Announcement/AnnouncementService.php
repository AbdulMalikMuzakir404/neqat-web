<?php

namespace App\Services\Announcement;

use App\Models\Announcement;
use App\Models\TemporaryFile;
use App\Services\LogActivity\LogActivityService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class AnnouncementService
{
    public $model, $tmpFileModel, $logactivity;

    public function __construct(Announcement $model, TemporaryFile $tmpFileModel, LogActivityService $logactivity)
    {
        $this->model = $model;
        $this->tmpFileModel = $tmpFileModel;
        $this->logactivity = $logactivity;
    }

    public function getOneData($id)
    {
        try {
            $data = $this->model->query();
            $data->where('id', $id);
            $result = $data->first();

            return $result;
        } catch (Exception $e) {
            Log::info("announcement service get announcement error : " . $e);

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
            Log::info("announcement service get data error : " . $e);

            return false;
        }
    }

    public function getAllDataTrash()
    {
        try {
            $data = $this->model->query();
            $data->where('is_delete', 1);
            $data->with(['user']);
            $result = $data->get();

            return $result;
        } catch (Exception $e) {
            Log::info("announcement service get announcement error : " . $e);

            return false;
        }
    }

    public function getAllDataTemp()
    {
        try {
            $data = $this->tmpFileModel;
            $result = $data->get();

            return $result;
        } catch (Exception $e) {
            Log::info("announcement service get announcement temporary error : " . $e);

            return false;
        }
    }

    public function storeData($req)
    {
        try {
            $data = $this->model->create([
                'user_id' => auth()->user()->id,
                'title' => $req->title,
                'description' => $req->description,
                'image' => '',
                'send_at' => Carbon::now(),
            ]);

           // buat sebuah log activity
           $desc = 'Membuat announcement ' . $data->title;
           $this->logactivity->storeData($desc);

            if ($req->image) {
                $tmp = json_decode($req->image);

                $tmpFile = $this->tmpFileModel->where('folder', $tmp->folder)->first();

                if ($tmpFile) {

                    $fileSystem = new Filesystem;

                    // Pindahkan file ke lokasi yang diinginkan
                    $oldPath = public_path('orders/temp/' . $tmpFile->folder . '/' . $tmpFile->filename);
                    $randomCode = Str::random(20); // 20 digit kode acak
                    $fileName = $randomCode . '-' . $tmpFile->filename;
                    $newDirectory = 'file/announcement/' . $data->id . '/' . $tmpFile->folder;
                    $newPath = public_path($newDirectory . '/' . $fileName);
                    $newFile = $newDirectory . '/' . $fileName;

                    // Pastikan direktori baru ada
                    if (!file_exists(public_path($newDirectory))) {
                        mkdir(public_path($newDirectory), 0777, true);
                    }

                    // Pindahkan file ke direktori baru
                    $fileSystem->move($oldPath, $newPath);

                    $data->update([
                        'image' => $newFile
                    ]);

                    // hapus folder sementara
                    File::deleteDirectory(public_path('orders/temp/' . $tmpFile->folder));

                    // Hapus record file sementara dari database
                    $tmpFile->delete();

                    return true;
                } else {
                    Log::info("data tmp tidak di temukan");

                    return false;
                }
            }

            return true;
        } catch (Exception $e) {
            Log::info("announcement service store data error : " . $e);

            return false;
        }
    }

    public function updateData($req)
    {
        try {
            $data = $this->model->where('id', $req->dataId)->first();

            $data->update([
                'title' => $req->title,
                'description' => $req->description,
                'send_at' => Carbon::now(),
            ]);

            // buat sebuah log activity
            $desc = 'Mengubah announcement ' . $data->title;
            $this->logactivity->storeData($desc);

            if ($req->image) {
                $tmp = json_decode($req->image);

                $tmpFile = $this->tmpFileModel->where('folder', $tmp->folder)->first();

                if ($tmpFile) {
                    if ($data->image) {
                        $imagePath = public_path('file/announcement/' . $data->id);
                        if (File::exists($imagePath)) {
                            File::deleteDirectory($imagePath); // Menghapus direktori beserta isinya
                        }
                    }

                    $fileSystem = new Filesystem;

                    // Pindahkan file ke lokasi yang diinginkan
                    $oldPath = public_path('orders/temp/' . $tmpFile->folder . '/' . $tmpFile->filename);
                    $randomCode = Str::random(20); // 20 digit kode acak
                    $fileName = $randomCode . '-' . $tmpFile->filename;
                    $newDirectory = 'file/announcement/' . $data->id . '/' . $tmpFile->folder;
                    $newPath = public_path($newDirectory . '/' . $fileName);
                    $newFile = $newDirectory . '/' . $fileName;

                    // Pastikan direktori baru ada
                    if (!file_exists(public_path($newDirectory))) {
                        mkdir(public_path($newDirectory), 0777, true);
                    }

                    // Pindahkan file ke direktori baru
                    $fileSystem->move($oldPath, $newPath);

                    $data->update([
                        'image' => $newFile
                    ]);

                    // hapus folder sementara
                    File::deleteDirectory(public_path('orders/temp/' . $tmpFile->folder));

                    // Hapus record file sementara dari database
                    $tmpFile->delete();

                    return true;
                } else {
                    Log::info("data tmp tidak di temukan");

                    return false;
                }
            }

            return true;
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
                $data->update([
                    'is_delete' => true
                ]);
            }

            // buat sebuah log activity
            $desc = 'Menghapus announcement ' . $data->name;
            $this->logactivity->storeData($desc);

            return $data;
        } catch (Exception $e) {
            Log::info("announcement service delete announcement error : " . $e);

            return false;
        }
    }

    public function deleteDataPermanen($req)
    {
        try {
            foreach ($req->ids as $id) {
                $data = $this->model->findOrFail($id);
                $data->delete();
            }

            // buat sebuah log activity
            $desc = 'Menghapus permanen announcement ' . $data->name;
            $this->logactivity->storeData($desc);

            return $data;
        } catch (Exception $e) {
            Log::info("announcement service delete announcement recovery error : " . $e);

            return false;
        }
    }

    public function recoveryData($req)
    {
        try {
            foreach ($req->ids as $id) {
                $data = $this->model->findOrFail($id);
                $data->update([
                    'is_delete' => false
                ]);
            }

            // buat sebuah log activity
            $desc = 'Recovery announcement ' . $data->name;
            $this->logactivity->storeData($desc);

            return $data;
        } catch (Exception $e) {
            Log::info("announcement service recovery announcement error : " . $e);

            return false;
        }
    }
}
