<?php

namespace App\Services\User;

use App\Exception\ErrorCode;
use App\Exception\RequestException;
use App\Helper\RequestHelper;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;
use PHPUnit\TextUI\XmlConfiguration\Logging\Logging;

class TokenService extends BaseService
{
    private function apiRequestWxAccessToken(string $code)
    {
        $url = sprintf(
            env('API_WX_REQUEST_LOGIN_TOKEN_URL'),
            env('WX_APP_ID'),
            env('WX_APP_SECRET'),
            $code
        );
        $response = RequestHelper::get($url);
        if (!is_string($response)) {
            return [];
        }
        $results = json_decode($response, true);
        return $results;
    }

    public function getCode(string $code): array
    {
        $results = $this -> apiRequestWxAccessToken($code);
        if (is_array($results)) {
            if (isset($results['errcode']) && $results['errcode'] != 0) {
                Log::info('wx-access-token', [
                    'msg' => '获取微信token异常',
                    'api' => $results
                ]);
                throw RequestException::create(ErrorCode::WX_API_REQUEST_ACCESS_TOKEN_EXCEPTION);
            }
            return $results;
        }
        Log::info('wx-access-token', [
            'msg' => '获取微信token异常',
            'api' => $results
        ]);
        throw RequestException::create(ErrorCode::WX_API_REQUEST_ACCESS_TOKEN_EXCEPTION);
    }
}
