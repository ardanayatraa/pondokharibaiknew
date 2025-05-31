<?php

namespace App\Jobs;

use App\Mail\ReservationCancelledMail;
use App\Mail\ReservationRescheduledMail;
use App\Models\Reservasi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $reservasi;
    public $newStatus; // bisa 'cancelled' atau 'reschedule'

    /**
     * Create a new job instance.
     *
     * @param  Reservasi  $reservasi
     * @param  string     $newStatus
     */
    public function __construct(Reservasi $reservasi, string $newStatus)
    {
        $this->reservasi = $reservasi;
        $this->newStatus = $newStatus;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Pilih Mailable berdasarkan $newStatus
        if ($this->newStatus === 'cancelled') {
            $mail = new ReservationCancelledMail($this->reservasi);
        } elseif ($this->newStatus === 'reschedule') {
            $mail = new ReservationRescheduledMail($this->reservasi);
        } else {
            return; // kalau bukan dua status di atas, tidak perlu kirim apa-apa
        }

        // Kirim email ke guest yang ada di $reservasi
        Mail::to($this->reservasi->guest->email)
            ->send($mail);
    }
}
