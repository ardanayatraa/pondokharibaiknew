<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tbl_villa_pricing', function (Blueprint $table) {
            // Kolom untuk menyimpan rentang tanggal yang dipilih
            $table->json('range_date_price')->nullable()->after('special_price_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_villa_pricing', function (Blueprint $table) {
            $table->dropColumn('range_date_price');
        });
    }
};
