<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CekKetersediaan extends Model
{
    use HasFactory;

    protected $table = 'tbl_cek_ketersediaan';
    protected $primaryKey = 'id_cek_ketersediaan';
    protected $fillable = ['villa_id', 'start_date', 'end_date'];

    public function villa()
    {
        return $this->belongsTo(Villa::class, 'villa_id');
    }
}
