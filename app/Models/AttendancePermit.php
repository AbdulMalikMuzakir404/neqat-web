<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendancePermit extends Model
{
    use HasFactory;

    protected $table = 'attendance_permits';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'id' => 'string',
    ];
}
