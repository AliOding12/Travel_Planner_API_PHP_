<?php

namespace App\Core;

use Monolog\Logger as MonologLogger;
use Monolog\Handler\StreamHandler;

class Logger
{
    private $logger;

    public function __construct()
    {
        $this->logger = new MonologLogger('universal_travel_api');
        $logPath = __DIR__ . '/../../logs/app.log';
        $this->logger->pushHandler(new StreamHandler($logPath, MonologLogger::DEBUG));
    }

   //i dont know why am i logging an info message like this but okay
    public function info(string $message, array $context = []): void
    {
        $this->logger->info($message, $context);
    }

   
    public function error(string $message, array $context = []): void
    {
        $this->logger->error($message, $context);
    }
}
?>