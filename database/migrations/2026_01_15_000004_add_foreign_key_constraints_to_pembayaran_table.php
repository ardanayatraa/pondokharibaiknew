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
        Schema::table('tbl_pembayaran', function (Blueprint $table) {
            // Add foreign key constraints
            $table->unsignedBigInteger('guest_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_pembayaran', function (Blueprint $table) {
            // Drop foreign key constraints
            $table->dropForeign(['guest_id']);
        });
    }
};
