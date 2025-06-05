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
        Schema::create('tbl_guest', function (Blueprint $table) {
            $table->id('id_guest');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('email')->unique();
            $table->string('full_name')->nullable();
            $table->text('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('id_card_number')->nullable();
            $table->string('passport_number')->nullable();
            $table->date('birthdate')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_guest');
    }
};
