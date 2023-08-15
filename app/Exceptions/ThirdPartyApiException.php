<?php

namespace App\Exceptions;

use Exception;
//for further exceptions like key mismatch create a exception of that here 
class ThirdPartyApiException extends Exception
{
    public function __construct(string $message, int $code = 502)
    {
        parent::__construct($message, $code);
    }
}
?>