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
            $table->uuid('id')->primary();
            $table->string('name', 50);
            $table->string('username', 50)->unique()->index();
            $table->string('email', 70)->unique()->index();
            $table->boolean('email_verified')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 100);
            $table->rememberToken();
            $table->boolean('active')->default(false);

            $table->string('fcm_token')->nullable();
            $table->timestamp('active_at')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->timestamp('first_access')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->timestamp('last_access')->nullable();
            $table->boolean('is_delete')->default(false);
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
