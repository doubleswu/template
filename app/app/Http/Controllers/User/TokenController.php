<?php

namespace App\Http\Controllers\User;

use App\Helper\OutPutHelper;
use App\Http\Controllers\BaseController;
use App\Services\User\LoginService;
use App\Services\User\TokenService;
use Illuminate\Http\Request;

class TokenController extends BaseController
{
    public function handler(Request $request)
    {
        try {
            $this -> ruleForParams($request, [
                'code' => 'required|max:100' ,
            ]);
            $code = $request -> input('code', '');
            /** @var $service TokenService */
            $service = app(TokenService::class);
            $results = $service -> getCode($code);
            OutPutHelper::success($results);
        } catch (\Exception $e) {
            OutPutHelper::error($e -> getCode(), $e -> getMessage());
        }
    }
}
