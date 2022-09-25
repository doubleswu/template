<?php

namespace App\Http\Middleware;

use App\Helper\OutPutHelper;
use App\Services\CasbinService;
use Closure;
use Illuminate\Http\Request;
use Casbin\Enforcer;
use CasbinAdapter\Database\Adapter;

/**
 * @desc 权限校验中间件
 */
class CasbinMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $enforcer = CasbinService::getInstances();
        $allow = $enforcer -> enforce('doubleswu', $request -> path(), $request -> method());
        if (!$allow) {
            OutPutHelper::error(500, 'Not allow');
        } else {
            return $next($request);
        }
    }
}
