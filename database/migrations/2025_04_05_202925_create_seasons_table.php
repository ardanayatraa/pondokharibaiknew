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
            $table->date('tgl_mulai_season');
            $table->date('tgl_akhir_season');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_season');
    }
};
