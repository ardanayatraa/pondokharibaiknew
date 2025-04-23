<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'tbl_report';
    protected $primaryKey = 'id_report';
    protected $fillable = ['report_type', 'date_range'];
}
