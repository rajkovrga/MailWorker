<?php


namespace App\Exceptions;


use Throwable;

class EmailVerifyException extends \Exception
{
    public function __construct($message = "User is not verified", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
