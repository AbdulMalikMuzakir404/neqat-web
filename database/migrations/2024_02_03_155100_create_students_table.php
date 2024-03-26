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
        Schema::create('students', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('class_room_id');
            $table->string('nis', 12);
            $table->string('nisn', 14);
            $table->string('phone', 15);
            $table->date('birth_date');
            $table->string('birth_place', 50);
            $table->enum('gender', ['pria', 'wanita']);
            $table->text('address', 255);
            $table->timestamps();

            $table->foreign('user_id')->references('id')
                ->on('users')
                ->cascadeOnDelete();
            $table->foreign('class_room_id')->references('id')
                ->on('class_rooms')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['class_room_id']);
        });

        Schema::dropIfExists('students');
    }
};
