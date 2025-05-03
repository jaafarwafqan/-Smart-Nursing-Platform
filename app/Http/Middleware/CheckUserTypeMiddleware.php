<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class CheckUserTypeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, $type): Response
    {
        $user = $request->user();
        if (!$user) {
            abort(403, 'Access denied');
        }
        if ($user->type !== $type) {
            abort(403, 'Access denied');
        }
        return $next($request);
    }
}
