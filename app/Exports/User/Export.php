<?php

namespace App\Exports\User;

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
            // Ambil semua data dari model dengan kriteria role name nya adalah selain 'student dan developer'
            $data = $this->model->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'student');
                $query->where('name', 'developer');
            })
                ->whereIn('id', $this->ids)
                ->get()
                ->toArray();

            foreach ($data as $item) {
                // Hapus kolom ID
                unset($item['id']);
                // Hapus kolom Is Delete
                unset($item['is_delete']);
                // Format data dengan mengganti nilai null dengan '-'
                $formattedData = array_map(function ($value) {
                    return $value !== null ? $value : '-';
                }, $item);
                $collection->push($formattedData);
            }
        } catch (Exception $e) {
            Log::error("User export error: " . $e->getMessage());
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
            'Active',
            'FCM Token',
            'Active At',
            'IP Address',
            'First Access',
            'Last Login',
            'Last Access',
            'Created At',
            'Updated At'
        ];
    }
}
