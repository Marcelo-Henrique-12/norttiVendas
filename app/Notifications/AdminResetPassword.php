<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminResetPassword extends Notification
{
    use Queueable;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Redefinição de Senha do Sistema Vendas Nortti')
            ->success()
            ->greeting('Prezado (a),')
            ->line('Você está recebendo este e-mail porque recebemos uma solicitação de redefinição de senha de sua conta.')
            ->action('REDEFINIR SENHA', url(config('app.url').route('admin.password.reset',['token' => $this->token,'email' => $notifiable->getEmailForPasswordReset(),], false)))
            ->line('Este link de redefinição de senha expirará em 60 minutos. Se você não solicitou uma redefinição de senha, nenhuma ação adicional será necessária.');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
