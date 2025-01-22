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
        Schema::create('weather_forecasts', function (Blueprint $table) {
            $table->id();
            $table->string('city_name');
            $table->string('timestamp_dt');
            $table->float('min_tmp');
            $table->float('max_tmp');
            $table->float('wind_spd');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weather_forecasts');
    }
};
