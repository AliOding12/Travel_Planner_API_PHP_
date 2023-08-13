<?php
//check and set accordingly for yourself
return [
    'openweathermap' => getenv('OPENWEATHERMAP_API_KEY') ?: '',
    'expedia' => getenv('EXPEDIA_API_KEY') ?: '',
    'eventbrite' => getenv('EVENTBRITE_API_KEY') ?: '',
];
?>