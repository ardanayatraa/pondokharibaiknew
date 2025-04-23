<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;

    protected $table = 'tbl_season';
    protected $primaryKey = 'id_season';
    protected $fillable = ['nama_season', 'tgl_mulai_season', 'tgl_akhir_season'];

    public function villaPricing()
    {
        return $this->hasMany(VillaPricing::class, 'season_id');
    }
}
