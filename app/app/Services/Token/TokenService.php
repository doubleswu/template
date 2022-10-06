<?php

namespace App\Services\Token;

use App\Exception\ErrorCode;
use App\Exception\RequestException;
use App\Helper\RequestHelper;
use App\Helper\StringHelper;
use App\Menu\UserLevelScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TokenService extends BaseToken
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
            $token = $this -> cacheToken($results);
            return [
                'token' => $token
            ];
        }
        Log::info('wx-access-token', [
            'msg' => '获取微信token异常',
            'api' => $results
        ]);
        throw RequestException::create(ErrorCode::WX_API_REQUEST_ACCESS_TOKEN_EXCEPTION);
    }

    private function prepareToCache(array $value): array
    {
        /** @var $request Request */
        $request = app(Request::class);
        $timestamp = $request -> input('timestamp');
        return [
            'openid' => $value['openid'] ?? '',
            'session_key' => $value['session_key'] ?? '',
            'time' => $timestamp,
            'scope' => UserLevelScope::NORMAL_LEVEL,
            'results' => $value ?? []
        ];
    }

    private function cacheToken(array $value): string
    {
        $key = self::generateToken();
        $flag = Cache::store('file') -> put(
            $key,
            $this -> prepareToCache($value),
            env('WX_APP_LOGIN_EXPIRE_TIME')
        );
        if (!$flag) {
            throw RequestException::create(ErrorCode::WX_SAVE_LOGIN_CACHE_EXCEPTION);
        }
        return $key;
    }
}
