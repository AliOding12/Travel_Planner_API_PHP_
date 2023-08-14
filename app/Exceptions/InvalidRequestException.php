<?php

namespace App\Exceptions;

use Exception;
//right now it is the only requirement 
class InvalidRequestException extends Exception
{
    public function __construct(string $message, int $code = 400)
    {
        parent::__construct($message, $code);
    }
}
?>