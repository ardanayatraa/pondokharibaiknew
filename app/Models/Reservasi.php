<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    protected $table = 'tbl_reservasi';
    protected $primaryKey = 'id_reservation';
    protected $fillable = [
        'guest_id', 'villa_id', 'cek_ketersediaan_id',
        'villa_pricing_id', 'start_date', 'end_date',
        'status', 'total_amount','cancelation_date',
        'cancelation_reason', 'status_pembayaran', 'batas_waktu_pembayaran',
        'status_check_in', 'tanggal_check_in_aktual', 'tanggal_check_out_aktual'
    ];

    public function guest()
    {
        return $this->belongsTo(Guest::class, 'guest_id');
    }

    public function villa()
    {
        return $this->belongsTo(Villa::class, 'villa_id');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'reservation_id');
    }
}
