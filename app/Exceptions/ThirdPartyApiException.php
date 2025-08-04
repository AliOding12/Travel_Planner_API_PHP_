<?php

namespace App\Exceptions;

use Exception;

class ThirdPartyApiException extends Exception
{
    public function __construct(string $message, int $code = 502)
    {
        parent::__construct($message, $code);
    }
}
?>