<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactMessage extends Notification implements ShouldQueue
{
    use Queueable;

    protected $fullName;
    protected $phone;
    protected $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($fullName, $phone, $message)
    {
        $this->fullName = $fullName;
        $this->phone = $phone;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('Bildirim')
                    ->line('İletişim formu aracılığıyla yeni bir mesaj aldınız.')
                    ->line('Mesaj detayları:')
                    ->line('Ad Soyad: ' . $this->fullName . '\nTelefon: ' . $this->phone . '\nMesaj: ' . $this->message);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'full_name' => $this->fullName,
            'phone' => $this->phone,
            'message' => $this->message
        ];
    }
}
