<?php

namespace App\Core;

use App\Services\WeatherClient;
use App\Services\HotelClient;
use App\Services\EventsClient;
use App\Transformers\WeatherTransformer;
use App\Transformers\HotelTransformer;
use App\Transformers\EventsTransformer;
use App\Exceptions\ThirdPartyApiException;

class ApiWrapper
{
    private $weatherClient;
    private $hotelClient;
    private $eventsClient;
    private $weatherTransformer;
    private $hotelTransformer;
    private $eventsTransformer;

    public function __construct()
    {
        $this->weatherClient = new WeatherClient();
        $this->hotelClient = new HotelClient();
        $this->eventsClient = new EventsClient();
        $this->weatherTransformer = new WeatherTransformer();
        $this->hotelTransformer = new HotelTransformer();
        $this->eventsTransformer = new EventsTransformer();
    }

   
    public function getDestinationData(string $city): array
    {
        $response = [
            'city' => $city,
            'weather' => null,
            'hotels' => null,
            'events' => null,
            'errors' => []
        ];

        try {
            $weatherData = $this->weatherClient->getWeather($city);
            $response['weather'] = $this->weatherTransformer->transform($weatherData);
        } catch (ThirdPartyApiException $e) {
            $response['errors'][] = ['weather' => $e->getMessage()];
        }

        try {
            $hotelData = $this->hotelClient->getHotels($city);
            $response['hotels'] = $this->hotelTransformer->transform($hotelData);
        } catch (ThirdPartyApiException $e) {
            $response['errors'][] = ['hotels' => $e->getMessage()];
        }

        try {
            $eventData = $this->eventsClient->getEvents($city);
            $response['events'] = $this->eventsTransformer->transform($eventData);
        } catch (ThirdPartyApiException $e) {
            $response['errors'][] = ['events' => $e->getMessage()];
        }

        return $response;
    }
}
?>