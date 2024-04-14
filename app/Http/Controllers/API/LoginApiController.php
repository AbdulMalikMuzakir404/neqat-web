<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Student\StudentService;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginApiController extends Controller
{
    use RedirectsUsers, ThrottlesLogins;

    public $service;

    public function __construct(StudentService $service)
    {
        $this->service = $service;
    }

    protected function validateLogin(Request $request)
    {
        return Validator::make($request->all(), [
            $this->username() => 'required',
            'password' => 'required'
        ]);
    }

    protected function attemptLogin(Request $request)
    {
        return Auth::guard('web')->attempt(
            $this->credentials($request),
            $request->filled('remember')
        );
    }

    public function username()
    {
        return 'username';
    }

    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'kode' => 400,
                'data' => null,
                'token' => null,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        if (Auth::attempt($request->only($this->username(), 'password'))) {
            $ipAddress = $request->ip();
            $idUser = Auth::user()->id;
            $now = Carbon::now('Asia/Jakarta');

            try {
                $user = User::findOrFail($idUser);
                $user->ip_address = $ipAddress;
                $user->first_access = $now;
                $user->save();
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return response()->json([
                    'success' => false,
                    'kode' => 404,
                    'data' => null,
                    'token' => null,
                    'message' => 'User not found',
                ], 404);
            }

            $role = $user->getRoleNames()->first();

            $data = $this->service->getOneData(auth()->user()->id);

            if ($role == "student") {
                return response()->json([
                    'success' => true,
                    'kode' => 200,
                    'data' => $data,
                    'token' => auth()->user()->createToken($user->email)->plainTextToken,
                    'message' => 'Login Success',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'kode' => 400,
                    'data' => null,
                    'token' => null,
                    'message' => 'Only Students Can Login',
                ], 400);
            }
        }

        return response()->json([
            'success' => false,
            'kode' => 401,
            'data' => null,
            'token' => null,
            'message' => 'username or password incorrect',
        ], 401);
    }


    public function logout(Request $request)
    {
        $ipAddress = $request->ip();

        $idUser = Auth::user()->id;

        $now = Carbon::now('Asia/Jakarta');

        $user = User::findOrFail($idUser);

        $user->ip_address = $ipAddress;
        $user->last_access = $now;
        $user->last_login = $now;

        $user->save();

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

    protected function guard()
    {
        return Auth::guard();
    }
}
