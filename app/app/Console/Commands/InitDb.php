<?php

namespace App\Console\Commands;

use App\Services\CasbinService;
use Illuminate\Console\Command;

class InitDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:InitDb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = config('casbin.RBAC.Users', []);
        $enforcer = CasbinService::getInstances('./config/casbin/model.conf');
        // 1、增加用户组
        foreach ($users as $user => $belongs) {
            foreach ($belongs as $belong) {
                $enforcer -> addRoleForUser($user , $belong);
            }
        }
        // 2、增加权限
        $apiInfo = config('casbin.RBAC.Apis', []);
        foreach ($apiInfo as $role => $apis) {
            foreach ($apis as $api => $methods) {
                foreach ($methods as $method) {
                    $enforcer -> addPermissionForUser($role , $api , $method);
                }
            }
        }

        // 3、超级用户
        $roles = config('casbin.RBAC.Roles', []);
        foreach ($roles as $role) {
            $enforcer -> addRoleForUser(env('CASBIN_ADMIN_USER_NAME') , $role);
        }
    }
}
