<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    // data dari form disimpan di sini, otomatis bisa diakses di view
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function build(): self
    {
        return $this
            ->subject('Pesan Baru dari Form Kontak Website')
            ->replyTo($this->data['email'], $this->data['name'])
            ->view('emails.contact-admin');
    }
}
