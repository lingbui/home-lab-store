<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomerResetPassword extends Notification
{
    /** @var string */
    public $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Đặt lại mật khẩu - Home Lab')
            ->greeting('Xin chào ' . $notifiable->name . ',')
            ->line('Bạn nhận được email này vì đã yêu cầu đặt lại mật khẩu tài khoản khách hàng.')
            ->action('Đặt lại mật khẩu', $this->url)
            ->line('Link có hiệu lực trong 60 phút. Nếu bạn không yêu cầu, hãy bỏ qua email này.');
    }
}
