<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
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
        } catch (\Exception $e) {
            echo $e -> getMessage();
        }
    }
}
