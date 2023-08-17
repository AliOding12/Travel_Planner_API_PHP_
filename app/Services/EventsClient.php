<?php

namespace App\Services;

use App\Cache\CacheManager;
use GuzzleHttp\Client;
use App\Exceptions\ThirdPartyApiException;

class EventsClient
{
    private $client;
    private $apiKey;
    private $cacheManager;

    public function __construct()
    { //make sure the URL works at this time it works if not then update it according to your need!
        $this->client = new Client(['base_uri' => 'https://www.eventbriteapi.com/v3/']);
        $this->apiKey = (require __DIR__ . '/../../config/api_keys.php')['eventbrite'];
        $this->cacheManager = new CacheManager();
    }

   
    public function getEvents(string $city): array
    {
        $cacheKey = "events_{$city}";
        $cachedData = $this->cacheManager->get($cacheKey);

        if ($cachedData !== null) {
            return $cachedData;
        }

        try {
            $response = $this->client->get('events/search', [
                'headers' => [
                    'Authorization' => "Bearer {$this->apiKey}"
                ],
                'query' => [
                    'location.address' => $city,
                    'expand' => 'venue'
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            $this->cacheManager->set($cacheKey, $data);
            return $data;
        } catch (\Exception $e) {
            throw new ThirdPartyApiException("Failed to fetch event data: " . $e->getMessage(), 502);
        }
    }
}
?>