<?php

namespace App\Helper;

use Illuminate\Http\Request;

class CommonHelper
{
    /**
     * @param string $token
     * @return array
     */
    public static function decryptLoginToken(): array
    {
        $request = app(Request::class);
        $userToken = OpenSSLHelper::aesDecrypt($request -> header('token'));
        list($mark , $userName , $userId , $loginTime) = explode(':', $userToken);
        return [
            'mark' => $mark,
            'userName' => $userName,
            'userId' => $userId,
            'loginTime' => $loginTime,
        ];
    }
}
