<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        return view('pages.home.index');
    }
}
