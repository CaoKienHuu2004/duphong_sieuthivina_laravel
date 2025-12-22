<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HuydonhangMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;// Thêm biến lý do

    /**
     * Create a new message instance.
     */
    public function __construct($order)
    {
        $this->order = $order;
        // $this->lydo = $lydo;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Đon hàng #' . $this->order->madon . ' đã bị hủy' ,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.huydonhang', // Tên view blade
        );
    }
}