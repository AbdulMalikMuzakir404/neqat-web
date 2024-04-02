<?php

namespace App\Exports\Student;

use Exception;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Export implements FromCollection, WithHeadings
{
    protected $model, $user, $ids;

    public function __construct($model, $user, array $ids)
    {
        $this->model = $model;
        $this->user = $user;
        $this->ids = $ids;
    }

    public function collection()
    {
        $collection = collect();

        try {
            // Ambil semua data dari model dengan kriteria role name nya adalah 'student' dan id nya berada dalam array $ids
            $data = $this->model->with(['user', 'classroom'])
                ->whereHas('user.roles', function ($query) {
                    $query->where('name', 'student');
                })
                ->whereIn('user_id', $this->ids)
                ->get();

            foreach ($data as $item) {
                // Format data
                $formattedData = [
                    $item->user->name,
                    $item->user->username,
                    $item->user->email,
                    $item->user->email_verified ? 'Yes' : 'No',
                    $item->user->email_verified_at ?? '-',
                    $item->user->active ? 'Yes' : 'No',
                    $item->user->fcm_token ?? '-',
                    $item->user->active_at ?? '-',
                    $item->nis ?? '-',
                    $item->nisn ?? '-',
                    $item->classroom ? $item->classroom->classname . ' - ' . $item->classroom->major : '-',
                    $item->gender ?? '-',
                    $item->user->ip_address ?? '-',
                    $item->phone ?? '-',
                    $item->birth_place ?? '-',
                    $item->birth_date ?? '-',
                    $item->address ?? '-',
                    $item->user->first_access ?? '-',
                    $item->user->last_login ?? '-',
                    $item->user->last_access ?? '-',
                    $item->created_at,
                    $item->updated_at
                ];

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
            'NIS',
            'NISN',
            'Class Room',
            'Gender',
            'IP Address',
            'Phone',
            'Birth Place',
            'Birth Date',
            'Address',
            'First Access',
            'Last Login',
            'Last Access',
            'Created At',
            'Updated At'
        ];
    }
}
