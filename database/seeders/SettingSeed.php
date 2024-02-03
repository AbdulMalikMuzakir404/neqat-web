<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeed extends Seeder
{
    public function run()
    {
        Setting::create([
            'school_name' => 'SMK NEGERI 1 KATAPANG',
            'location_name' => 'XGRW+XV9, Jl. Ceuri, Katapang, Kec. Katapang, Kabupaten Bandung, Jawa Barat 40921, Indonesia',
            'latitude' => '-7.009488414554536',
            'longitude' => '107.5472574134918',
            'radius' => '100',
            'school_time_from' => '07:00',
            'school_time_to' => '15:00',
            'school_hour_tolerance' => '09:00'
        ]);
    }
}
