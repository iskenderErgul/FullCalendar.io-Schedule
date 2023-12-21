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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->enum('day_number', ['1','2','3','4','5','6','7']);

            $table->unsignedBigInteger('week_id');
            $table->string('title');
            $table->string('description');
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();

            $table->foreign('week_id')->references('week_id')->on('weeks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
