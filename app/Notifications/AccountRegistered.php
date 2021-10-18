<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Core\Models\Auth\User;

class AccountRegistered extends Notification
{
    use Queueable;

    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
            ->subject(config('app.name') . ' Üyelik Aktivasyonu')
            ->greeting('Merhaba!')
            ->line(config('app.name') . ' hesabınız başarıyla oluşturuldu. Sipariş verebilmek ve hesabınızı tam olarak kullanabilmek için lütfen hesabınızı doğrulayınız.')
            ->action('Hesabı Doğrula', route('store.auth.activate', ['code' => $this->user->activation_code, 'id' => $this->user->id]))
            ->line('Eğer hesabınızı siz oluşturmadıysanız, bu e-postayı yok sayabilirsiniz.');
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
            //
        ];
    }
}
