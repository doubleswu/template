<?php

namespace App\Http\Middleware;

use App\Helper\OpenSSLHelper;
use Closure;

class AuthMiddleware
{
    public function handle($request, Closure $next)
    {
        $token = $request -> header('token');
        $response = $next($request);
        // 执行操作
        return $response;
    }
}
