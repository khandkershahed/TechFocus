<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckScopedAccess
{
    public function handle(Request $request, Closure $next, $model): Response
    {
        // Get the authenticated admin user
        $admin = auth()->guard('admin')->user();
        
        // Alternative method: $admin = $request->user('admin');

        if (!$admin) {
            abort(403, 'Unauthorized');
        }

        if ($admin->hasRole('SuperAdmin')) {
            return $next($request);
        }

        $modelInstance = $request->route($model);
        
        if (!$modelInstance) {
            abort(404);
        }

        // Check if admin is creator
        if ($modelInstance->creator_id === $admin->id) {
            return $next($request);
        }

        // Check scoped access
        if (!$admin->hasAccessTo($modelInstance)) {
            abort(403, 'Access denied');
        }

        return $next($request);
    }
}