<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tbl_admin', function (Blueprint $table) {
            $table->id('id_admin');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('email')->unique();
            $table->string('tipe')->default('admin'); // admin atau resepsionis
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_admin');
    }
};
