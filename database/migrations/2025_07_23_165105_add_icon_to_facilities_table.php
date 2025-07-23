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
        Schema::table('tbl_facility', function (Blueprint $table) {
            $table->string('icon')->default('fa-check-circle')->after('facility_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_facility', function (Blueprint $table) {
            $table->dropColumn('icon');
        });
    }
};
