<?php

namespace App\Services;

use App\Cache\CacheManager;
use GuzzleHttp\Client;
use App\Exceptions\ThirdPartyApiException;

class HotelClient
{
    private $client;
    private $apiKey;
    private $cacheManager;

    public function __construct()
    {   //check URL validity 
        $this->client = new Client(['base_uri' => 'https://hotels4.p.rapidapi.com/']);
        $this->apiKey = (require __DIR__ . '/../../config/api_keys.php')['expedia'];
        $this->cacheManager = new CacheManager();
    }


    public function getHotels(string $city): array
    {
        $cacheKey = "hotels_{$city}";
        $cachedData = $this->cacheManager->get($cacheKey);

        if ($cachedData !== null) {
            return $cachedData;
        }

        try {
            $response = $this->client->get('locations/v2/search', [
                'headers' => [
                    'X-RapidAPI-Key' => $this->apiKey,
                    'X-RapidAPI-Host' => 'hotels4.p.rapidapi.com'
                ],
                'query' => [
                    'query' => $city,
                    'locale' => 'en_US'
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            $this->cacheManager->set($cacheKey, $data);
            return $data;
        } catch (\Exception $e) {
            throw new ThirdPartyApiException("Failed to fetch hotel data: " . $e->getMessage(), 502);
        }
    }
}
?>