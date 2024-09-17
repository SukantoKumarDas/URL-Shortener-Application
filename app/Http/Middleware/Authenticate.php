<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // return $request->expectsJson() ? null : route('login');

        // Determine the guard that was triggered and set the corresponding login route
        if ($request->expectsJson()) {
            return null;
        }

        // Check if the current route belongs to the admin guard
        if ($request->is('admin') || $request->is('admin/*')) {
            return route('admin.login');  // Redirect to admin login if accessing admin routes
        }
        // Default for user login
        return route('login');  // Redirect to the user login route
    }
}
