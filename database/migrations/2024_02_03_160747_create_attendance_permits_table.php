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
        Schema::create('attendance_permits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('attendance_id');
            $table->dateTime('date');
            $table->text('description', 255);
            $table->text('image', 255);
            $table->tinyInteger('status')->default(0);
            $table->timestamps();

            $table->foreign('attendance_id')->references('id')
                ->on('attendances')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendance_permits', function (Blueprint $table) {
            $table->dropForeign(['attendance_id']);
        });

        Schema::dropIfExists('attendance_permits');
    }
};
