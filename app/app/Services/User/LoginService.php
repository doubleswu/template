<?php

namespace App\Services\User;

use App\Exception\ErrorCode;
use App\Exception\SourceException;
use App\Helper\OpenSSLHelper;
use App\Models\UsersModel;

class LoginService
{
    public function handler(array $params): array
    {
        $row = UsersModel::query()->where('user_name', $params['username'] ?? '') -> first();
        if (empty($row)) {
            throw SourceException::create(ErrorCode::RESOURCE_NOT_FIND);
        }
        if (trim($params['password']) != $row -> pass_word) {
            throw SourceException::create(ErrorCode::USER_ACCOUNT_CMP_ERROR);
        }
        $encryptUserInfo = OpenSSLHelper::aesEncrypt(sprintf(
            '%s:%s:%d:%d',
            env('USER_TOKEN_MARK'),
            $row -> user_name,
            $row -> id,
            time()
        ));
        return [
            'username' => $row -> user_name,
            'token' => $encryptUserInfo
        ];
    }
}
