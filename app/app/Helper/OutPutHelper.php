<?php

namespace App\Helper;

use Illuminate\Http\Request;
use Psy\Util\Json;

class OutPutHelper
{
    public static function success(array $results = []): string
    {
        $request = app(Request::class);
        echo Json::encode(self::template($results, 0, '', $request -> input('requestId')));
        die();
    }

    public static function error(int $code = 0, string $msg = ''): string
    {
        $request = app(Request::class);
        echo Json::encode(self::template([], $code, $msg, $request -> input('requestId')));
        die();
    }

    private static function template(
        array $results = [],
        int $code = 0,
        string $msg = '',
        ?string $requestId = ''
    ): array {
        return [
            'code' => $code,
            'msg' => $msg,
            'requestId' => $requestId,
            'results' => $results
        ];
    }
}
