<?php

namespace App\Services\Announcement;

use App\Models\Announcement;
use Exception;
use Illuminate\Support\Facades\Log;

class AnnouncementService
{
    public $model;

    public function __construct(Announcement $model)
    {
        $this->model = $model;
    }

    public function getData()
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

    public function storeData($data)
    {
        try {
            $data = $this->model->create([
                'title' => $data->title,
                'description' => $data->description,
                'email' => $data->email,
            ]);

            return $data;
        } catch (Exception $e) {
            Log::info("announcement service store data error : " . $e);

            return false;
        }
    }

    public function updateData($data)
    {
        try {
            $data = $this->model->where('id', $data->data_id)->first();

            $data->update([
                'title' => $data->title_edit,
                'description' => $data->description_edit,
                'email' => $data->email_edit,
            ]);

            return $data;
        } catch (Exception $e) {
            Log::info("announcement service store data error : " . $e);

            return false;
        }
    }

    public function deleteData($data)
    {
        try {
            foreach ($data->ids as $id) {
                $user = $this->model->findOrFail($id);
                $user->delete();
            }

            return $user;
        } catch (Exception $e) {
            Log::info("announcement service delete data error : " . $e);

            return false;
        }
    }
}
