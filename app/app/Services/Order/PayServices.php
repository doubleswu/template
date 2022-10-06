<?php

namespace App\Services\Order;

use App\Exception\ErrorCode;
use App\Exception\RequestException;
use App\Services\Token\BaseToken;
use WeChatPay\Builder;
use WeChatPay\Crypto\Rsa;
use WeChatPay\Util\PemUtil;

class PayServices extends BaseToken
{
    private string $orderId;

    public function __construct(string $orderId = '')
    {
        $this -> orderId = $orderId;
    }

    public function pay()
    {
        // 1、校验订单是否有效

        // 2、校验商品库存

        // 3、订单是否已经支付

        // 满足上面条件，创建一个微信预支付的订单号
        $this -> makeWeChatPreOrderId();
    }


    private function makeWeChatPreOrderId()
    {
        // openId
        $openId = self::currentToken();
        if (empty($openId)) {
            throw RequestException::create(ErrorCode::WX_REQUEST_API_HEADER_TOKEN_EXCEPTION);
        }
        try {
            $client = $this -> getClient();
            $resp = $client -> chain('v3/pay/transactions/jsapi')
                -> post([
                    'mchid'=>env('PAY_MERCHANT_ID'),
                    'out_trade_no'=>'1900006XXX',
                    'appid'=>env('WX_APP_ID'),
                    'description'=>'测试微信支付',
                    'notify_url'=>'https://api.likeghost.club/wechat/pay/callback', # 通知地址
                    'amount' => [
                        'total' => 1, # 订单总金额，单位为分。
                        'currency' => 'CNY'
                    ]
                ]);
            echo $resp->getStatusCode(), PHP_EOL;
            echo $resp->getBody(), PHP_EOL;
        } catch (\Exception $e) {
            // 进行错误处理
            echo $e->getMessage(), PHP_EOL;
            if ($e instanceof \GuzzleHttp\Exception\RequestException && $e->hasResponse()) {
                $r = $e->getResponse();
                echo $r->getStatusCode() . ' ' . $r->getReasonPhrase(), PHP_EOL;
                echo $r->getBody(), PHP_EOL, PHP_EOL, PHP_EOL;
            }
            echo $e->getTraceAsString(), PHP_EOL;
        }

    }
}
