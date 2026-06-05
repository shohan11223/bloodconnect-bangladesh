<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LogActivity
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (auth()->check() && $request->isMethod('post', 'put', 'delete', 'patch')) {
            \App\Models\ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => $request->method(),
                'model_type' => $request->route()?->getController()?->class,
                'description' => $request->path(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        return $response;
    }
}