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
        Schema::create('hours', function (Blueprint $table) {
            $table->id('hour_id');
            $table->string('hour_range');
            $table->integer('day_id');
            $table->timestamps();

            $table->foreign('day_id')->references('day_id')->on('days');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hours');
    }
};
