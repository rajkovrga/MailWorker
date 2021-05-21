<?php


namespace App\Exceptions;


use Throwable;

class NotActiveException extends \Exception
{
    public function __construct($message = "User is not active", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }



    public function render()
    {
        return response()->json(['message' => 'User is not active'], 405);
    }

}
