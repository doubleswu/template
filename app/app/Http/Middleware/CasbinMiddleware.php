<?php

namespace App\Http\Middleware;

use App\Exception\ErrorCode;
use App\Exception\RequestException;
use App\Helper\CommonHelper;
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
        if (!env('ALLOW_VALIDATE_API_PERMISSION')) {
            return $next($request);
        }
        try {
            $enforcer = CasbinService::getInstances();
            $userInfo = CommonHelper::decryptLoginToken();
            $allow = $enforcer -> enforce($userInfo['userName'], $request -> path(), $request -> method());
            if (!$allow) {
                throw RequestException::create(ErrorCode::PERMISSION_NOT_ALLOW);
            }
            return $next($request);
        } catch (\Exception $e) {
            OutPutHelper ::error($e -> getCode(), $e -> getMessage());
        }
    }
}
