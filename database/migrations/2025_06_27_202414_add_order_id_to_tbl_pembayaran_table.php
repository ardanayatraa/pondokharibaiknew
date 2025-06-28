<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tbl_pembayaran', function (Blueprint $table) {
            $table->string('order_id');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_pembayaran', function (Blueprint $table) {
            $table->dropColumn('order_id');
        });
    }
};
