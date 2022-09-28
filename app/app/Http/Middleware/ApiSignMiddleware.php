<?php

namespace App\Http\Middleware;

use App\Exception\ErrorCode;
use App\Exception\RequestException;
use App\Helper\CommonHelper;
use App\Helper\OpenSSLHelper;
use App\Helper\OutPutHelper;
use Closure;
use Faker\Extension\Helper;
use Illuminate\Http\Request;

class ApiSignMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!env('ALLOW_SIGN_VALIDATE_API_REQUEST', false)) {
            return $next($request);
        }
        try {
            $request -> validate([
                'timestamp' => 'required|digits:10',
                'sign' => 'required|max:100',
                'token' => 'required|max:100',
                'requestId' => 'required|max:100',
            ]);
            $this -> validateSign($request);
            return $next($request);
        } catch (\Throwable $e) {
            OutPutHelper::error($e -> getCode(), $e -> getMessage());
        }
    }

    private function validateSign(Request $request)
    {
        $slat = env('API_REQUEST_SIGN_RANDSTR');
        $timestamp = $request -> input('timestamp');
        $sign = $request -> input('sign');
        $token = $request -> header('token');
        $cmpSign = md5($timestamp . '|' . $token . '|' . $slat);
        if ($cmpSign != $sign) {
            throw RequestException::create(ErrorCode::REQUEST_PARAMS_SIGN_CMP_ERROR);
        }
        if (time() - $timestamp > env('API_REQUEST_SIGN_EXPIRE_TIME')) {
            throw RequestException::create(ErrorCode::REQUEST_PARAMS_SIGN_EXPIRE_TIME);
        }
        $userToken = CommonHelper::decryptLoginToken($token);
        if ($userToken['mark'] != env('USER_TOKEN_MARK')) {
            throw RequestException::create(ErrorCode::REQUEST_PARAMS_TOKEN_EXCEPTION);
        }
        if (time() - $userToken['loginTime'] >= env('USER_LOGIN_TOKEN_EXPIRE_TIME')) {
            throw RequestException::create(ErrorCode::REQUEST_PARAMS_USER_LOGIN_NO_EXPIRE_TIME);
        }
    }
}
