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
        Schema::table('tbl_report', function (Blueprint $table) {
            // Drop existing columns
            $table->dropColumn(['start_date', 'end_date']);
            
            // Add date_range column to match model
            $table->string('date_range')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_report', function (Blueprint $table) {
            // Drop date_range column
            $table->dropColumn('date_range');
            
            // Add back original columns
            $table->date('start_date');
            $table->date('end_date');
        });
    }
}; 