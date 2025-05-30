<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendances';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'id' => 'string',
    ];
}
