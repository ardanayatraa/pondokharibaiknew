<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailToParent extends Mailable
{
    use Queueable, SerializesModels;

    public $nama;

    public function __construct($nama)
    {
        $this->nama = $nama;
    }

    public function build()
    {
        return $this->subject('Info Penting dari Sekolah')
                    ->view('emails.to-parent')
                    ->attach(storage_path('app/public/dummy-info.pdf'), [
                        'as' => 'Informasi-Anak.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
}
