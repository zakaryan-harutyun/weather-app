<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeatherForecast extends Model
{
    protected $fillable = [
        'city_name',
        'timestamp_dt',
        'min_tmp',
        'max_tmp',
        'wind_spd',
        'updated_at'
    ];
}
