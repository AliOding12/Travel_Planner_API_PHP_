<?php

namespace App\Transformers;

class EventsTransformer
{

    public function transform(array $data): array
    {
        $events = [];
        $rawEvents = $data['events'] ?? [];

        foreach ($rawEvents as $event) {
            $events[] = [
                'name' => $event['name']['text'] ?? '',
                'start_time' => $event['start']['local'] ?? '',
                'venue' => $event['venue']['name'] ?? '',
                'url' => $event['url'] ?? ''
            ];
        }

        return $events;
    }
}
?>