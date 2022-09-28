<?php

namespace App\Exception;

use Throwable;

class RequestException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent ::__construct($message, $code, $previous);
    }

    public static function create(int $code)
    {
        return new self(ErrorCode::getMessage($code), $code);
    }
}
