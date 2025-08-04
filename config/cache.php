<?php

return [
    'driver' => 'sqlite',
    'ttl' => (int) (getenv('CACHE_TTL') ?: 3600), 
];
?>