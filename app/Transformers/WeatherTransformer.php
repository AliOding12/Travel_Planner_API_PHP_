<?php

namespace App\Transformers;

class WeatherTransformer
{

    public function transform(array $data): array
    {
        return [
            'city' => $data['name'] ?? '',
            'temperature' => $data['main']['temp'] ?? null,
            'description' => $data['weather'][0]['description'] ?? '',
            'humidity' => $data['main']['humidity'] ?? null,
            'wind_speed' => $data['wind']['speed'] ?? null,
            'timestamp' => $data['dt'] ?? time()
        ];
    }
}
?>