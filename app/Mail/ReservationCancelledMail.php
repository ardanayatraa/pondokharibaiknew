<?php
// app/Mail/ReservationCancelledMail.php

namespace App\Mail;

use App\Models\Reservasi;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationCancelledMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservasi;

    public function __construct(Reservasi $reservasi)
    {
        $this->reservasi = $reservasi;
    }

    public function build()
    {
        return $this
            ->subject('Bukti Refund Reservasi #' . $this->reservasi->id_reservation)
            ->view('emails.reservation.cancelled'); // pakai view HTML
    }
}
