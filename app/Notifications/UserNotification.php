<?php

namespace App\Notifications;

use App\Models\Despesa;
use App\Models\User;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $despesa;

    /**
     * Create a new notification instance.
     */
    public function __construct(Despesa $despesa)
    {
        $this->despesa = $despesa;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Onfly | Despesa cadastrada')
                    ->greeting('Olá, ' . $notifiable->name)
                    ->line('Você tem uma nova despesa registrada!')
                    ->line('Despesa : ' . $this->despesa->descricao)
                    ->line('Valor: R$ ' . number_format($this->despesa->valor, 2, ',', '.'))
                    ->line('Data: ' . date('d/m/Y',strtotime($this->despesa->data)))
                    ->line('Obrigado pelo voto de confiança à nossa equipe.')
                    ->salutation("Atenciosamente, Onfly.");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
