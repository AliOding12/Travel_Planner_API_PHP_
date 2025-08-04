<?php

namespace App\Services;

use App\Cache\CacheManager;
use GuzzleHttp\Client;
use App\Exceptions\ThirdPartyApiException;

class WeatherClient
{
    private $client;
    private $apiKey;
    private $cacheManager;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'https://api.openweathermap.org/data/2.5/']);
        $this->apiKey = (require __DIR__ . '/../../config/api_keys.php')['openweathermap'];
        $this->cacheManager = new CacheManager();
    }

  
    public function getWeather(string $city): array
    {
        $cacheKey = "weather_{$city}";
        $cachedData = $this->cacheManager->get($cacheKey);

        if ($cachedData !== null) {
            return $cachedData;
        }

        try {
            $response = $this->client->get('weather', [
                'query' => [
                    'q' => $city,
                    'appid' => $this->apiKey,
                    'units' => 'metric'
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            $this->cacheManager->set($cacheKey, $data);
            return $data;
        } catch (\Exception $e) {
            throw new ThirdPartyApiException("Failed to fetch weather data: " . $e->getMessage(), 502);
        }
    }
}
?>