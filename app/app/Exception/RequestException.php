<?php

namespace App\Exception;

use Throwable;

class RequestException extends \Exception
{
    public const REQUEST_PARAMS_ERRORS = 100003;
    public const REQUEST_PARAMS_SIGN_CMP_ERROR = 100004;

    public const MAP = [
        self::REQUEST_PARAMS_ERRORS => '请求参数异常',
        self::REQUEST_PARAMS_SIGN_CMP_ERROR => '签名对比异常'
    ];

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent ::__construct($message, $code, $previous);
    }

    public static function create(int $code)
    {
        return new self(ErrorCode::getMessage($code), $code);
    }
}
