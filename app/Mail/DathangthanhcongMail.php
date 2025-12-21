<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\DonhangModel;

class DathangThanhcongMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order; // Biến chứa dữ liệu đơn hàng

    public function __construct(DonhangModel $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->subject('Đặt hàng thành công #' . $this->order->madon)
                    ->markdown('mail.dathang_thanhcong'); // Dùng markdown() để có giao diện đẹp
    }
}