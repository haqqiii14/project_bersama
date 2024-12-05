<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $role)
    {
        $user = auth()->user();

        if (!$user || $user->type !== $role) {
            // Redirect to specific routes based on role
            if ($user->type === 'admin') {
                return redirect()->route('admin/AdminHome')->with('error', 'You are redirected as an admin.');
            } elseif ($user->type === 'user') {
                return redirect()->route('home')->with('error', 'You are redirected as a user.');
            }

            // Default response for unauthorized access
            return response()->json(['message' => 'You do not have permission to access this page.'.$role], 403);
        }

        return $next($request);
    }
}
