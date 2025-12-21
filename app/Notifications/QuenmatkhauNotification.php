<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QuenmatkhauNotification extends Notification
{
    use Queueable;

    public $token;
    public $email;

    // Nhận token và email từ Controller truyền sang
    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    // Đây là đoạn dùng View Mail có sẵn của Laravel
    public function toMail($notifiable)
    {
        // Link trỏ về Frontend (Next.js)
        $frontendUrl = env('FRONTEND_URL', 'http://localhost:3000');
        $url = "{$frontendUrl}/doi-mat-khau?token={$this->token}&email={$this->email}";

        return (new MailMessage)
                    ->subject('[Siêu Thị Vina] Yêu cầu đặt lại mật khẩu') // Tiêu đề mail
                    ->greeting('Xin chào bạn!') // Lời chào
                    ->line('Bạn nhận được email này vì chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn.')
                    ->action('Đặt lại mật khẩu', $url) // Nút bấm (Laravel tự render nút xanh đẹp)
                    ->line('Link này sẽ hết hạn sau 60 phút.')
                    ->line('Nếu bạn không yêu cầu, vui lòng bỏ qua email này.');
    }
}