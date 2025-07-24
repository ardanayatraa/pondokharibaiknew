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
            // Kolom untuk harga khusus (tidak berdasarkan hari)
            $table->decimal('special_price', 10, 2)->nullable()->after('saturday_pricing');

            // Kolom untuk menentukan apakah menggunakan harga khusus atau harga per hari
            $table->boolean('use_special_price')->default(false)->after('special_price');

            // Kolom untuk deskripsi harga khusus (misalnya "Harga Liburan Natal")
            $table->string('special_price_description')->nullable()->after('use_special_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_villa_pricing', function (Blueprint $table) {
            $table->dropColumn('special_price');
            $table->dropColumn('use_special_price');
            $table->dropColumn('special_price_description');
        });
    }
};
