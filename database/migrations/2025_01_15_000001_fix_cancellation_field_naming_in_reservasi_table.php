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
        Schema::table('tbl_reservasi', function (Blueprint $table) {
            // Rename cancellation_reason to cancelation_reason to match model
            $table->renameColumn('cancellation_reason', 'cancelation_reason');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_reservasi', function (Blueprint $table) {
            // Rename back to cancellation_reason
            $table->renameColumn('cancelation_reason', 'cancellation_reason');
        });
    }
}; 