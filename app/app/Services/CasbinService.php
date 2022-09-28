<?php

namespace App\Services;

use Casbin\Enforcer;
use CasbinAdapter\Database\Adapter;

class CasbinService extends BaseService
{
    /**
     * @return Enforcer
     * @throws \Casbin\Exceptions\CasbinException
     */
    public static function getInstances(string $path = '../config/casbin/model.conf'): Enforcer
    {
        $config = [
            'type'     => 'mysql', // mysql,pgsql,sqlite,sqlsrv
            'hostname' => env('DB_HOST'),
            'database' => env('DB_DATABASE'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'hostport' => env('DB_PORT'),
        ];
        $adapter = Adapter::newAdapter($config);
        $enforcer = new Enforcer($path, $adapter);
        return $enforcer;
    }
}
