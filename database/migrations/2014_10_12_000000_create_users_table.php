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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->boolean('active')->default(false);

            $table->timestamp('active_at')->nullable();
            $table->bigInteger('userable_id')->nullable();
            $table->string('userable_type')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->timestamp('first_access')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->timestamp('last_access')->nullable();
            $table->timestamp('created_at')->nullable();
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
