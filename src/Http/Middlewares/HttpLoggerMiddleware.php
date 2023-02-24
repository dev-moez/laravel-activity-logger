<?php

namespace Moez\ActivityLogger\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Moez\ActivityLogger\Services\HttpLogService;

class HttpLoggerMiddleware
{

    public function __construct(public readonly HttpLogService $HttpLogService) {}

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->HttpLogService->log($request);
        return $next($request);
    }
}
