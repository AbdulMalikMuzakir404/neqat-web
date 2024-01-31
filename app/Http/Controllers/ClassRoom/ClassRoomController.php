<?php

namespace App\Http\Controllers\ClassRoom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClassRoomController extends Controller
{
    public function index()
    {
        return view('pages.classroom.index');
    }
}
