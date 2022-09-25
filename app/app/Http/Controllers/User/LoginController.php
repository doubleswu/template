<?php

namespace App\Http\Controllers\User;

use App\Helper\OutPutHelper;
use App\Http\Controllers\BaseController;
use App\Services\User\LoginService;
use Illuminate\Http\Request;

/**
 * @desc 返回用户登陆的token
 */
class LoginController extends BaseController
{
    public function handler(Request $request)
    {
        try {
            $this -> ruleForParams($request, [
                'username' => 'required|max:255',
                'password' => 'required|max:255',
            ]);
            $userName = $request -> input('username', '');
            $password = $request -> input('password', '');
            /** @var $service LoginService */
            $service = app(LoginService::class);
            $results = $service -> handler([
                'username' => $userName,
                'password' => $password,
            ]);
            OutPutHelper::success($results);
        } catch (\Exception $e) {
            OutPutHelper::error($e -> getCode(), $e -> getMessage());
        }
    }
}
