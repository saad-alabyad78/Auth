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

            $table->unsignedBigInteger('role_id')->nullable();
            $table->string('role_type')->nullable();

            $table->string('provider')->nullable();

            $table->string('first_name');
            $table->string('last_name')->nullable();

            $table->string('email')->unique();
            $table->dateTime('email_verified_at')->nullable();
            $table->string('email_otp_code')->nullable();
            $table->dateTime('email_otp_expired_date')->nullable();

            $table->string('password');
            $table->string('password_otp_code')->nullable();
            $table->dateTime('password_otp_expired_date')->nullable();
            
            $table->index(['role_id' , 'role_type' , 'email']);

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
