<?php

namespace App\Exception;

class ErrorCode
{
    public const DEFAULT = 100000;
    public const RESOURCE_NOT_FIND = 100001;
    public const USER_ACCOUNT_CMP_ERROR = 100002;
    public const REQUEST_PARAMS_ERRORS = 100003;
    public const REQUEST_PARAMS_SIGN_CMP_ERROR = 100004;
    public const REQUEST_PARAMS_SIGN_EXPIRE_TIME = 100005;
    public const REQUEST_PARAMS_TOKEN_EXCEPTION = 100006;
    public const REQUEST_PARAMS_USER_LOGIN_NO_EXPIRE_TIME = 100007;

    # 权限相关
    public const PERMISSION_NOT_ALLOW = 200001;

    # 微信相关
    public const WX_API_REQUEST_ACCESS_TOKEN_EXCEPTION = 300001;
    public const WX_SAVE_LOGIN_CACHE_EXCEPTION = 300002;

    public const MAP = [
        self::DEFAULT => 'Error',
        self::RESOURCE_NOT_FIND => '资源查询失败',
        self::USER_ACCOUNT_CMP_ERROR => '账号密码对比失败',
        self::REQUEST_PARAMS_ERRORS => '请求参数异常',
        self::REQUEST_PARAMS_SIGN_CMP_ERROR => '签名对比异常',
        self::REQUEST_PARAMS_SIGN_EXPIRE_TIME => '请求过期',
        self::REQUEST_PARAMS_TOKEN_EXCEPTION => 'Token异常',
        self::REQUEST_PARAMS_USER_LOGIN_NO_EXPIRE_TIME => '用户登陆超时，请重新登陆',
        self::PERMISSION_NOT_ALLOW => '您没有访问该模块的权限',
        self::WX_API_REQUEST_ACCESS_TOKEN_EXCEPTION => '获取微信token异常',
        self::WX_SAVE_LOGIN_CACHE_EXCEPTION => '服务器缓存Token异常',
    ];

    public static function getMessage(int $code)
    {
        return self::MAP[$code] ?? '';
    }
}
