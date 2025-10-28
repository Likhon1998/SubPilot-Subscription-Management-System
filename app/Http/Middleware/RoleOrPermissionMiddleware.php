<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleOrPermissionMiddleware
{
    public function handle($request, Closure $next, $roleOrPermission)
    {
        $user = Auth::user();

        if (!$user || (!$user->hasRole($roleOrPermission) && !$user->hasPermissionTo($roleOrPermission))) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
