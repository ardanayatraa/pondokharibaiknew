<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class Guest extends Authenticatable
{
    use HasFactory;

    protected $table = 'tbl_guest';
    protected $primaryKey = 'id_guest';
    protected $fillable = [
        'username', 'password', 'email', 'full_name',
        'address', 'phone_number', 'id_card_number',
        'passport_number', 'birthdate', 'gender'
    ];

    public function reservasi()
    {
        return $this->hasMany(Reservasi::class, 'guest_id');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'guest_id');
    }
}
