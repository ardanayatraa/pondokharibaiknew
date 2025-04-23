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
        Schema::create('tbl_facility', function (Blueprint $table) {
            $table->id('id_facility');
            $table->string('name_facility');
            $table->text('description')->nullable();
            $table->string('facility_type');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_facility');
    }
};
