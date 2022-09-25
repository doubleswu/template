<?php

namespace App\Http\Controllers;
use Casbin\Enforcer;
use CasbinAdapter\Database\Adapter as DatabaseAdapter;

class TestController extends BaseController
{
    public function handler()
    {
        $config = [
            'type'     => 'mysql', // mysql,pgsql,sqlite,sqlsrv
            'hostname' => env('DB_HOST'),
            'database' => env('DB_DATABASE'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'hostport' => env('DB_PORT'),
        ];
        $adapter = DatabaseAdapter::newAdapter($config);
        $e = new Enforcer('../conf/model.conf', $adapter);
        echo 123;
    }
}
