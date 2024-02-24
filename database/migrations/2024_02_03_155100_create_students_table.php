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
            $table->id();
            $table->uuid('user_id');
            $table->unsignedBigInteger('school_program_id');
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
            $table->foreign('school_program_id')->references('id')
                ->on('school_programs')
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
            $table->dropForeign(['school_program_id']);
        });

        Schema::dropIfExists('students');
    }
};
