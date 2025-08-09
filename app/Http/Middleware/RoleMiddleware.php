<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use App\Http\Traits\ApiTraits;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    use ApiTraits;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = auth()->user();
        if (!$user) {
            return $this->unauthorized();
        }
        if (!in_array($user->role->name, $roles)) {
            return $this->forbidden($roles, $user->role->name,  403);
        }
        return $next($request);
    }

    protected function unauthenticated($request, array $guards)
    {
        return response()->json([
            'error' => 'Unauthenticated. Please login.'
        ], 401);
    }
}
