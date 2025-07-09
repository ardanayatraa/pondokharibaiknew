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
        Schema::table('tbl_villa_pricing', function (Blueprint $table) {
            // Drop the auto-increment primary key
            $table->dropPrimary();
            
            // Change id_villa_pricing to string type and make it primary key
            $table->string('id_villa_pricing')->primary()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_villa_pricing', function (Blueprint $table) {
            // Drop the string primary key
            $table->dropPrimary();
            
            // Change back to auto-increment integer primary key
            $table->id('id_villa_pricing')->change();
        });
    }
}; 