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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->decimal('from_lat', 30);
            $table->decimal('from_long', 30);
            $table->decimal('to_lat', 30);
            $table->decimal('to_long', 30);
            $table->string('location_name', 100);
            $table->tinyInteger('attendance_status')->default(0);
            $table->dateTime('time_in');
            $table->string('token_in', 100);
            $table->dateTime('time_out');
            $table->string('token_out', 100);
            $table->timestamps();

            $table->foreign('user_id')->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('attendances');
    }
};
