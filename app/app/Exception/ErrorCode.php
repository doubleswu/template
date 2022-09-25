<?php

namespace App\Exception;

class ErrorCode
{
    public const RESOURCE_NOT_FIND = 100001;
    public const USER_ACCOUNT_CMP_ERROR = 100002;

    public const MAP = [
        self::RESOURCE_NOT_FIND => '资源查询失败',
        self::USER_ACCOUNT_CMP_ERROR => '账号密码对比失败'
    ];

    public static function getMessage(int $code)
    {
        return self::MAP[$code] ?? '';
    }
}
