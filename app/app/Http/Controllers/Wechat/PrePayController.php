<?php

namespace App\Http\Controllers\Wechat;

use App\Helper\OutPutHelper;
use App\Http\Controllers\BaseController;
use App\Services\Order\PayServices;
use Illuminate\Http\Request;

class PrePayController extends BaseController
{
    public function handler(Request $request)
    {
        try {
//            $this -> ruleForParams($request, [
//                'code' => 'required|max:100' ,
//            ]);
//            $code = $request -> input('code', '');
            /** @var $service PayServices */
            $service = app(PayServices::class);
            $service -> pay();
            OutPutHelper::success([]);
        } catch (\Exception $e) {
            OutPutHelper::error($e -> getCode(), $e -> getMessage());
        }
    }
}
