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
        Schema::create('tbl_season', function (Blueprint $table) {
            $table->id('id_season');
            $table->string('nama_season');
            $table->date('tgl_mulai_season')->nullable();
            $table->date('tgl_akhir_season')->nullable();

            // season mingguan atau tahunan
            $table->boolean('repeat_weekly')
                  ->default(false)
                  ->comment('true = season berdasar hari tiap minggu');
            $table->json('days_of_week')
                  ->nullable()
                  ->comment('array hari 0=Minggu ... 6=Sabtu jika repeat_weekly=true');

            // prioritas ketika tumpang tindih rentang tanggal
            $table->unsignedInteger('priority')
                  ->default(0)
                  ->comment('prioritas pengecekan season jika overlap');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_season');
    }
};
