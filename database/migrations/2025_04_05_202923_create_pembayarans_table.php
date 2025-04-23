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
        Schema::create('tbl_pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->foreignId('guest_id');
            $table->foreignId('reservation_id');
            $table->decimal('amount', 10, 2);
            $table->date('payment_date');
            $table->string('snap_token')->nullable();
            $table->text('notifikasi')->nullable();
            $table->enum('status', ['pending', 'paid'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_pembayaran');
    }
};
