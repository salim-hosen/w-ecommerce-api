<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Notifications\VerifyEmail as Notification;
use Illuminate\Support\Facades\URL;
use App\Models\User;

class VerifyEmail extends Notification
{

    protected function verificationUrl($notifiable)
    {

        $user = User::where('email', $notifiable->getEmailForPasswordReset())->first();

        $url = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            ['user' => $notifiable->id]
        );

        $appUrl = config('app.client_url');

        return str_replace(url('/api'), $appUrl, $url);
    }

}
