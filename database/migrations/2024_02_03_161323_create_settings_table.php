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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('school_name', 50);
            $table->string('location_name', 100);
            $table->string('latitude', 50);
            $table->string('longitude', 50);
            $table->integer('radius');
            $table->boolean('absen')->default(false);
            $table->time('school_time_from');
            $table->time('school_time_to');
            $table->time('school_hour_tolerance');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
