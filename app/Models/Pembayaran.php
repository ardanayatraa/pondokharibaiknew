<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'tbl_pembayaran';
    protected $primaryKey = 'id_pembayaran';
    protected $fillable = ['guest_id', 'reservation_id', 'amount', 'payment_date', 'snap_token', 'notifikasi', 'status'];

    public function guest()
    {
        return $this->belongsTo(Guest::class, 'guest_id');
    }

    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class, 'reservation_id');
    }
}
