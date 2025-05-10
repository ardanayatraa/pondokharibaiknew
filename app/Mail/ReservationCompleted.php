<?php

namespace App\Mail;

use App\Models\Reservasi;
use App\Models\Pembayaran;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class ReservationCompleted extends Mailable
{
    use Queueable, SerializesModels;

    public $reservasi;
    public $pembayaran;

    /**
     * Create a new message instance.
     */
    public function __construct(Reservasi $reservasi, Pembayaran $pembayaran)
    {
        $this->reservasi  = $reservasi;
        $this->pembayaran = $pembayaran;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        // hitung durasi menginap
        $start  = Carbon::parse($this->reservasi->start_date);
        $end    = Carbon::parse($this->reservasi->end_date);
        $nights = $end->diffInDays($start);

        // generate PDF invoice tanpa alias, sertakan $start & $nights
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('invoices.reservation_invoice', [
            'reservasi'  => $this->reservasi,
            'pembayaran' => $this->pembayaran,
            'start'      => $start,
            'nights'     => $nights,
        ]);

        return $this
            ->subject('Detail Reservasi & Invoice Anda')
            ->markdown('emails.reservation_completed', [
                'reservasi'  => $this->reservasi,
                'pembayaran' => $this->pembayaran,
                'start'      => $start,
                'nights'     => $nights,
            ])
            ->attachData(
                $pdf->output(),
                "invoice_{$this->reservasi->id_reservation}.pdf",
                ['mime' => 'application/pdf']
            );
    }
}
