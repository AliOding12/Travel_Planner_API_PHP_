<?php

namespace App\Transformers;

class HotelTransformer
{
 
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