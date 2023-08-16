<?php

namespace App\Transformers;

class HotelTransformer
{
 // for future and a bigger picture of such api server i tend to create a utils file and store all these transformers there if you can please contribute

    public function transform(array $data): array
    {
        $hotels = [];
        $suggestions = $data['suggestions'][0]['entities'] ?? [];

        foreach ($suggestions as $entity) {
            if ($entity['type'] === 'HOTEL') {
                $hotels[] = [
                    'name' => $entity['name'] ?? '',
                    'latitude' => $entity['latitude'] ?? null,
                    'longitude' => $entity['longitude'] ?? null,
                    'destination_id' => $entity['destinationId'] ?? ''
                ];
            }
        }

        return $hotels;
    }
}
?>