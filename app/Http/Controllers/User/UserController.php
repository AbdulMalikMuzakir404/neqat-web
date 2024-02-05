<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\User\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public $service;

    public function __construct(UserService $service) {
        $this->service = $service;
    }

    public function index()
    {
        $data['users'] = $this->service->getUser();

        return view('pages.user.index', compact('data'));
    }
}
