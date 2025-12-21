<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LienheMail extends Mailable
{
    use Queueable, SerializesModels;

    public $dataInfo; // Biến này sẽ truyền sang View

    /**
     * Create a new message instance.
     */
    public function __construct($dataInfo)
    {
        $this->dataInfo = $dataInfo;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('🔔 [Siêu Thị Vina] Có liên hệ mới từ khách hàng')
                    ->markdown('mail.lienhe'); // Trỏ đến file view template
    }
}