<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Verification\Email\CustomeVerificationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class CustomeVerificationController extends Controller
{
    protected $verifyEmailService;

    public function __construct(CustomeVerificationService $verifyEmailService)
    {
        $this->verifyEmailService = $verifyEmailService;
    }

    public function showVerificationForm()
    {
        return view('notifications.email.email');
    }

    public function sendVerificationEmail()
    {
        $data['email'] = Auth::user()->email;
        $data['link'] = URL::temporarySignedRoute(
            'custome.verification.verify',
            now()->addSeconds(60),
            ['token' => Auth::user()->id]
        );

        $this->verifyEmailService->sendVerificationEmail($data);

        return redirect()->back()->with('resent', 'Verifikasi email berhasil dikirim.');
    }

    public function verifyEmail($token)
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            return redirect('/home');
        }

        $this->verifyEmailService->verifyEmail($user);

        return redirect('/home')->with('success', 'Email berhasil diverifikasi!');
    }
}
