<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        foreach ($roles as $role) {
            if ($request->user() && ($request->user()->tokenCan($role) || $request->user()->type==$role)) {
                return $next($request);
            }
        }
        return response()->json(['message' => 'Unauthenticated.'], 401);
    }
}
