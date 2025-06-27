<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateStatusEnumOnTblPembayaranTable extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE tbl_pembayaran MODIFY status ENUM('pending', 'paid', 'refunded') DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE tbl_pembayaran MODIFY status ENUM('pending', 'paid') DEFAULT 'pending'");
    }
}
