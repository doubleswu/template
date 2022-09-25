<?php

namespace App\Http\Controllers;

use App\Helper\OutPutHelper;
use Casbin\Enforcer;
use CasbinAdapter\Database\Adapter as DatabaseAdapter;

class TestController extends BaseController
{
    public function handler()
    {
        return OutPutHelper::success();
    }
}
