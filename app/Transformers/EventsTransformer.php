<?php

namespace App\Transformers;

class EventsTransformer
{
// for future and a bigger picture of such api server i tend to create a utils file and store all these transformers there if you can please contribute
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