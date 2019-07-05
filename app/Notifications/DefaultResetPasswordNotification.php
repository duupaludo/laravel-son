<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class DefaultResetPasswordNotification extends ResetPassword
{

    public function toMail($notifiable)
    {
        /**
         * Get the mail representation of the notification.
         *
         * @param  mixed $notifiable
         * @return \Illuminate\Notifications\Messages\MailMessage
         */

        return (new MailMessage)
            ->subject('Redefinição de senha')
            ->line('Você está recebendo esse e-mail, porque uma redefinição de senha foi solicitada.')
            ->action('Redefinir senha', url(config('app.url').route('password.reset', $this->token, false)))
            ->line('Se por acaso você não fez essa solicitação, pode ignorar esse e-mail.');
    }

}
