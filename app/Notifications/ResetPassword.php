<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;
use App\Models\User;

class ResetPassword extends Notification
{

    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        if (static::$createUrlCallback) {
            $url = call_user_func(static::$createUrlCallback, $notifiable, $this->token);
        } else {
            
            $user = User::where('email', $notifiable->getEmailForPasswordReset())->first();

            $url = url(config($user->role == 1 ? 'app.admin_url' : 'app.client_url').'/password/reset/'.$this->token).'?email='.$notifiable->getEmailForPasswordReset();
            // $url = url(route('password.reset', [
            //     'token' => $this->token,
            //     'email' => $notifiable->getEmailForPasswordReset(),
            // ], false));
        }

        return $this->buildMailMessage($url);
    }


}
