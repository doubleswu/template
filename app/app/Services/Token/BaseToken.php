<?php

namespace App\Services\Token;

use App\Exception\ErrorCode;
use App\Exception\RequestException;
use App\Helper\StringHelper;
use App\Services\BaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use WeChatPay\Crypto\Rsa;
use WeChatPay\Util\PemUtil;
use WeChatPay\Builder;

class BaseToken extends BaseService
{
    /**
     * @desc 创建一个token
     * @return string
     */
    public static function generateToken(): string
    {
        $token = StringHelper::randString();
        /** @var $request Request */
        $request = app(Request::class);
        $timestamp = $request -> input('timestamp');
        return md5($token . '|' . $timestamp . '|' . env('AES_ENCRYPT_SECRET'));
    }

    /**
     * @param string $cacheKey  [openid|session_key|time]
     * @return string
     * @throws RequestException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public static function currentToken(string $cacheKey = 'openid'): string
    {
        /** @var $request Request */
        $request = app(Request::class);
        $token = $request -> header('token');
        if (empty($token)) {
            throw RequestException::create(ErrorCode::WX_REQUEST_API_HEADER_TOKEN_EXCEPTION);
        }
        $results = Cache::store('file') -> get($token);
        if (is_array($results)) {
            return $results[$cacheKey] ?? '';
        }
        throw RequestException::create(ErrorCode::WX_REQUEST_API_HEADER_TOKEN_EXCEPTION);
    }

    /**
     * @desc 构造一个 APIv3 客户端实例
     * https://pay.weixin.qq.com/wiki/doc/apiv3/apis/chapter3_5_1.shtml
     */
    public function getClient()
    {
        $merchantId = env('PAY_MERCHANT_ID');
        $merchantPrivateKeyFilePath = './source/apiclient_key.pem';
        $merchantPrivateKeyInstance = Rsa::from($merchantPrivateKeyFilePath, Rsa::KEY_TYPE_PRIVATE);

        // PAY_MERCHANT_SERIALIZATION_ID
        $merchantCertificateSerial = env('PAY_MERCHANT_SERIALIZATION_ID');
        $platformCertificateFilePath = './source/apiclient_cert.pem';
        $platformPublicKeyInstance = Rsa::from($platformCertificateFilePath, Rsa::KEY_TYPE_PUBLIC);
        $platformCertificateSerial = PemUtil::parseCertificateSerialNo($platformCertificateFilePath);

        // 构造一个 APIv3 客户端实例
        $client = Builder::factory([
            'mchid'      => $merchantId,
            'serial'     => $merchantCertificateSerial,
            'privateKey' => $merchantPrivateKeyInstance,
            'certs'      => [
                $platformCertificateSerial => $platformPublicKeyInstance,
            ],
        ]);
        return $client;
    }
}
