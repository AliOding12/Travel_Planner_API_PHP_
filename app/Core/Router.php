<?php

namespace App\Core;

use App\Core\ApiWrapper;
use App\Exceptions\InvalidRequestException;

class Router
{
    private $routes = [];

    public function __construct()
    {   //add further routes if needed here 
       
        $this->addRoute('GET', '/destination/([a-zA-Z0-9-]+)', [$this, 'handleDestination']);
    }

  
    public function addRoute(string $method, string $pattern, callable $handler): void
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'pattern' => $pattern,
            'handler' => $handler
        ];
    }

    public function handleRequest(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match('#^' . $route['pattern'] . '$#', $uri, $matches)) {
                array_shift($matches);
                call_user_func_array($route['handler'], $matches);
                return;
            }
        }

        throw new InvalidRequestException('Route not found', 404);
    }

  
    public function handleDestination(string $city): void
    {
        try {
            $apiWrapper = new ApiWrapper();
            $response = $apiWrapper->getDestinationData($city);
            http_response_code(200);
            echo json_encode($response, JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            throw new InvalidRequestException($e->getMessage(), $e->getCode() ?: 500);
        }
    }
}
?>