<?php

namespace App\Helper;

use GuzzleHttp\Client;

class RequestHelper
{
    /**
     * @desc GET请求
     * @param string $url
     * @param float $timeout
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function get(string $url, float $timeout = 2.0)
    {
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => $url,
            // You can set any number of default request options.
            'timeout'  => $timeout,
        ]);
        $response = $client -> request('GET');
        return $response -> getBody() -> getContents() ?? null;
    }
}
