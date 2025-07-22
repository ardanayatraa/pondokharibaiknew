<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservasi;
use Carbon\Carbon;

class CancelExpiredReservasi extends Command
{
    protected $signature = 'reservasi:cancel-expired';
    protected $description = 'Batalkan reservasi dengan status_pembayaran pending yang sudah melewati batas waktu pembayaran';

    public function handle()
    {
        $now = Carbon::now();
        $expired = Reservasi::where('status_pembayaran', 'pending')
            ->where('batas_waktu_pembayaran', '<', $now)
            ->get();

        foreach ($expired as $r) {
            $r->update([
                'status_pembayaran' => 'failed',
                'status' => 'cancelled',
                'cancelation_date' => $now,
                'cancelation_reason' => 'Pembayaran tidak dilakukan hingga batas waktu',
            ]);
        }

        $this->info('Reservasi expired dibatalkan: ' . $expired->count());
    }
} 