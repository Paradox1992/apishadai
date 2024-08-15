<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AlertMail extends Notification
{
    use Queueable;

    protected $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Obtiene los canales de entrega de la notificación.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Obtiene la representación en correo de la notificación.
     */
    public function toMail($notifiable)
    {
        $mailMessage = (new MailMessage)
            ->from($this->details['from'], 'ShadaiAlerts')
            ->subject($this->details['subject'])
            ->markdown('Notifications.RegistroESTemplate', [
                'subject' => $this->details['subject'],
                'body' =>  $this->details['data'],
                'url' => url('/')
            ])
            ->cc('791gerardo791@gmail.com');
        return $mailMessage;
    }

    /**
     * Obtiene la representación en arreglo de la notificación.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable): array
    {
        return [
            'data' => $this->details['data'],
            'subject' => $this->details['subject'],
            'from' => $this->details['from'],
        ];
    }
}