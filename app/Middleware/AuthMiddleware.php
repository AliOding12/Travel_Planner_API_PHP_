<?php

namespace App\Middleware;

use App\Exceptions\InvalidRequestException;
//donot add a separate JWT based one herjust create another file for it in the middleware directory 
class AuthMiddleware
{
    private $apiKey;

    public function __construct()
    {
       
        $this->apiKey = getenv('API_KEY') ?: 'your_default_api_key';
    }

 
    public function handle(): void
    {
        $headers = getallheaders();
        $requestApiKey = $headers['X-API-Key'] ?? '';

        if (empty($requestApiKey) || $requestApiKey !== $this->apiKey) {
            throw new InvalidRequestException('Invalid or missing API key', 401);
        }
    }
}
?>