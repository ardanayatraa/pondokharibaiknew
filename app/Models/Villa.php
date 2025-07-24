<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Models\Facility;
use App\Models\Reservasi;
use App\Models\VillaPricing;
use App\Models\CekKetersediaan;

class Villa extends Model
{
    use HasFactory;

    protected $table = 'tbl_villa';
    protected $primaryKey = 'id_villa';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'facility_id',
        'name',
        'description',
        'picture',
        'capacity',
    ];

    protected $casts = [
        'facility_id' => 'array',
    ];

    // —— RELATIONS —— //

    public function reservasi()
    {
        return $this->hasMany(Reservasi::class, 'villa_id');
    }

    public function pricings()
    {
        return $this->hasMany(VillaPricing::class, 'villa_id', 'id_villa');
    }

    public function cekKetersediaan()
    {
        return $this->hasMany(CekKetersediaan::class, 'villa_id', 'id_villa');
    }

}
