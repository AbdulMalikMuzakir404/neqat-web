<?php

namespace App\Exports\User;

use Exception;
use Illuminate\Support\Collection;
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
            // Ambil semua data dari model
            $data = $this->model->get()->toArray();
            foreach ($data as $item) {
                // Pilih kolom-kolom yang ingin diekspor
                $selectedData = [
                    'Name' => $item['name'],
                    'Username' => $item['username'],
                    'Email' => $item['email'],
                    // Tambahkan kolom-kolom lain yang ingin diekspor di sini...
                ];

                // Format data dengan mengganti nilai null dengan '-'
                $formattedData = array_map(function ($value) {
                    return $value !== null ? $value : '-';
                }, $selectedData);

                $collection->push($formattedData);
            }
        } catch (Exception $e) {
            Log::error("User export error: " . $e->getMessage());
            // Tampilkan pesan kesalahan atau tangani kesalahan dengan cara yang sesuai
        }

        return $collection;
    }


    public function headings(): array
    {
        return [
            'Name',
            'Username',
            'Email',
            'Email Verified',
            'Email Verified At',
            'Password',
            'Remember Token',
            'Active',
            'FCM Token',
            'Active At',
            'IP Address',
            'First Access',
            'Last Login',
            'Last Access',
            'Is Delete',
            'Created At',
            'Updated At'
        ];
    }
}
