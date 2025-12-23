<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\DonhangModel;

class CapNhatTrangThaiMail extends Mailable
{
    use Queueable, SerializesModels;

    public $donhang;
    public $tieude;
    public $noidung;
    public $urlchitiet;

    public function __construct(DonhangModel $donhang, $tieude, $noidung)
    {
        $this->donhang = $donhang;
        $this->tieude = $tieude;
        $this->noidung = $noidung;
        // Giả định route chi tiết đơn hàng
        $this->urlchitiet = route('chi-tiet-don-hang', $donhang->madon); 
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->tieude . ' #' . $this->donhang->madon,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.capnhatdonhang', // Sử dụng markdown view
        );
    }
}