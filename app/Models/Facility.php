<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $table = 'tbl_facility';
    protected $primaryKey = 'id_facility';
    protected $fillable = ['name_facility', 'description', 'facility_type'];

    public function villas()
    {
        return $this->hasMany(Villa::class, 'facility_id');
    }
}
