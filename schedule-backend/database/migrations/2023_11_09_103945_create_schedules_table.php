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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('day_id');
            $table->unsignedBigInteger('hour_id');
            $table->unsignedBigInteger('task_id');
            $table->timestamps();

            $table->foreign('day_id')->references('day_id')->on('days');
            $table->foreign('hour_id')->references('hour_id')->on('hours');
            $table->foreign('task_id')->references('task_id')->on('tasks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};

