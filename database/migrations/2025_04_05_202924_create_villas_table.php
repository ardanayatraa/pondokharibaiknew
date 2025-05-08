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
        Schema::create('tbl_villa', function (Blueprint $table) {
            $table->id('id_villa');
            $table->json('facility_id');
            $table->string('name');
            $table->string('picture');
            $table->string('capacity');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_villa');
    }
};
