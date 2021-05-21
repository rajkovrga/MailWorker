<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class PasswordUserIsNotCorrectException extends Exception
{
    public function __construct($message = "Password is not valid", $code = 406, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function render()
    {
        return response()->json(['message' => 'Password is not valid'], 405);
    }
}
