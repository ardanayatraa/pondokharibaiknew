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
        Schema::create('tbl_villa_pricing', function (Blueprint $table) {
            $table->id('id_villa_pricing');
            $table->foreignId('villa_id');
            $table->foreignId('season_id');
            $table->decimal('sunday_pricing', 10, 2);
            $table->decimal('monday_pricing', 10, 2);
            $table->decimal('tuesday_pricing', 10, 2);
            $table->decimal('wednesday_pricing', 10, 2);
            $table->decimal('thursday_pricing', 10, 2);
            $table->decimal('friday_pricing', 10, 2);
            $table->decimal('saturday_pricing', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_villa_pricing');
    }
};
