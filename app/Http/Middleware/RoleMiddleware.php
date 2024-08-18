<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Log::info('RoleMiddlewareが実行されました');
        if (auth()->user()->role == 'admin') {
            Log::info('adminロールのユーザーがアクセスしました');
            return $next($request);
        }
        return redirect()->route('dashboard');
        // return $next($request);
    }
}
