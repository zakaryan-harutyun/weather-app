<?php

namespace App\Http\Controllers;

use App\ApiResponse;
use App\Http\Requests\SaveWeatherRequest;
use Illuminate\Http\Request;
use App\Models\WeatherForecast;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    private $apiKey = 'e4b8b08c185638b825af37facfe1fabb';

    public function index()
    {
        return view('weather');
    }

    public function fetchWeather(Request $request)
    {
        $city = $request->input('city_name');
        $response = Http::get("http://api.openweathermap.org/data/2.5/forecast", [
            'q' => $city,
            'units' => 'metric',
            'appid' => $this->apiKey
        ]);

        return response()->json($response->json());
    }

    public function saveWeather(SaveWeatherRequest $request)
    {
        $data = $request->validated();

        $forecast = WeatherForecast::updateOrCreate(
            ['city_name' => $data['city_name']],
            [
                'timestamp_dt' => $data['timestamp_dt'],
                'min_tmp' => $data['min_tmp'],
                'max_tmp' => $data['max_tmp'],
                'wind_spd' => $data['wind_spd'],
                'updated_at' => now()
            ]
        );

        return ApiResponse::success($forecast, 'Weather data saved successfully!');
    }

    public function loadWeather($city)
    {
        $forecast = WeatherForecast::whereRaw('LOWER(city_name) = ?', [strtolower($city)])->first();
        if (!$forecast) {
            return ApiResponse::error('Weather data not found for the specified city.', 404);
        }

        return ApiResponse::success($forecast, 'Weather data retrieved successfully!');
    }
}
