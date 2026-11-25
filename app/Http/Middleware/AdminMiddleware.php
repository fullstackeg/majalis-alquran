<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // التحقق مما إذا كان المستخدم مسجلاً ومسؤولاً (is_admin == true)
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'غير موصول: لا تملك صلاحيات الدخول لوحة التحكم.');
        }

        return $next($request);
    }
}
