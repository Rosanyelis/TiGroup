<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExpiryContractAdminNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
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
        // $email = 'rosanyelismendoza@gmail.com';
        $email = ['rosanyelismendoza@gmail.com', 'juan@tigroup.cl', 'ventas@tigroup.cl'];
        return (new MailMessage)
                ->subject('TiGroup - ¡Contrato de Cliente por Expirar!')
                // ->to($email)
                ->from('rosanyelismendoza@gmail.com')
                ->view('emails.ExpiryContractAdmin',
                [
                    'customer' => $this->data['customer'],
                    'type_contract' => $this->data['type_contract']
                ]);
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
