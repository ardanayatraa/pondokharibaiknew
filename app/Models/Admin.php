<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'tbl_admin';
    protected $primaryKey = 'id_admin';
    protected $fillable = ['username', 'password', 'email', 'tipe'];
}
