<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            $table->string('email')->unique();
            $table->dateTime('email_verified_at')->nullable();
            $table->string('email_otp_code')->nullable();
            $table->dateTime('email_otp_expired_date')->nullable();

            $table->string('phone_number')->nullable() ;//TODO? should it be uniqe ????
            $table->dateTime('phone_number_verified_at')->nullable();
            $table->string('phone_number_otp_code')->nullable();
            $table->dateTime('phone_number_otp_expired_date')->nullable();

            $table->string('password');
            $table->string('password_otp_code')->nullable();
            $table->dateTime('password_otp_expired_date')->nullable();
            
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
