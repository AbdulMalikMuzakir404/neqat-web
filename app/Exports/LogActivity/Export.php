<?php

namespace App\Exports\LogActivity;

use Exception;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Export implements FromCollection, WithHeadings
{
    protected $model, $ids;

    public function __construct($model, array $ids)
    {
        $this->model = $model;
        $this->ids = $ids;
    }

    public function collection()
    {
        $collection = collect();

        try {
            // Ambil data dari model hanya dengan kolom yang diinginkan
            $data = $this->model->with(['user:id,name'])->whereIn('id', $this->ids)->get(['user_id', 'description', 'created_at', 'updated_at'])->toArray();

            // Ubah nama kolom user_id menjadi user.name
            foreach ($data as &$item) {
                $item['user']['name'] = $item['user']['name'] ?? '-';
                unset($item['user_id']);
            }

            // Lakukan proses ekspor dengan data yang telah dipilih
            foreach ($data as $item) {
                $collection->push([
                    'Name' => $item['user']['name'],
                    'Description' => $item['description'],
                    'Created' => $item['created_at'],
                    'Updated' => $item['updated_at']
                ]);
            }
        } catch (Exception $e) {
            Log::error("Log Activity export error: " . $e->getMessage());
        }

        return $collection;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Description',
            'Created',
            'Updated'
        ];
    }
}
