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
        Schema::create('tbl_reservasi', function (Blueprint $table) {
            $table->id('id_reservation');
            $table->foreignId('guest_id')->nullable();
            $table->foreignId('villa_id');
            $table->foreignId('cek_ketersediaan_id')->nullable();
            $table->foreignId('villa_pricing_id')->nullable();
            $table->date('end_date');
            $table->date('start_date');
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'rescheduled'])->default('pending');
            $table->decimal('total_amount', 10, 2);
            $table->enum('status_pembayaran', ['pending', 'success', 'failed'])->default('pending');
            $table->timestamp('batas_waktu_pembayaran')->nullable();
            $table->enum('status_check_in', ['pending', 'checked_in', 'checked_out'])->default('pending');
            $table->timestamp('tanggal_check_in_aktual')->nullable();
            $table->timestamp('tanggal_check_out_aktual')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_reservasi');
    }
};
