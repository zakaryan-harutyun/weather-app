<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WeatherController;

Route::get('/', [WeatherController::class, 'index']);
Route::post('/get-weather', [WeatherController::class, 'fetchWeather']);
Route::post('/save-weather', [WeatherController::class, 'saveWeather']);
Route::get('/load-weather/{city}', [WeatherController::class, 'loadWeather']);

