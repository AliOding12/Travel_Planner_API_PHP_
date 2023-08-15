<?php

namespace App\Transformers;

class WeatherTransformer
{
// for future and a bigger picture of such api server i tend to create a utils file and store all these transformers there if you can please contribute

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