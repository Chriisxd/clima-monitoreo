<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    public function getByCity(string $city, int $userId): array
    {
        try {
            $response = Http::timeout(10)->get(
                'https://api.openweathermap.org/data/2.5/weather',
                [
                    'q' => $city,
                    'appid' => config('services.openweather.key'),
                    'units' => 'metric',
                    'lang' => 'es',
                ]
            );

            if ($response->failed()) {
                Log::error('Error OpenWeather API', [
                    'user_id' => $userId,
                    'city' => $city,
                    'status' => $response->status(),
                ]);

                throw new \Exception('Ciudad no encontrada o error en la API');
            }

            return $response->json();

        } catch (\Throwable $e) {
            Log::critical('Fallo conexión OpenWeather', [
                'user_id' => $userId,
                'city' => $city,
                'error' => $e->getMessage(),
            ]);

            throw new \Exception('Servicio climático no disponible');
        }
    }
}