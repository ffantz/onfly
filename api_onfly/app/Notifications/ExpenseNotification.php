<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Expense;

class ExpenseNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        $this->onConnection('redis');
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
            ->from('testeonfly@mail.com')
            ->subject('Nova despesa cadastrada')
            ->greeting('Ola, ' . $notifiable->user->name . '!')
            ->line('Voce tem uma nova despesa cadastrada: ')
            ->line('Descrição: ' . $notifiable->description)
            ->line('Data: ' . \Carbon\Carbon::createFromDate($notifiable->date)->format('d/m/Y'))
            ->line('Valor: R$ ' . number_format($notifiable->cost), 2, ',', '.')
            ->salutation('Atenciosamente, Onfly')
            ;
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
