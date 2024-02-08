<?php

namespace App\Services\Verification\Email;

use App\Mail\CustomeVerification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CustomeVerificationService
{
    public function sendVerificationEmail($data)
    {
        Mail::to($data['email'])->send(new CustomeVerification($data));
    }

    public function verifyEmail($user)
    {
        $user->update([
            'email_verified' => true,
            'email_verified_at' => Carbon::now(),
        ]);
    }
}
