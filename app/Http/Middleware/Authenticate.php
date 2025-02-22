<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            // Redirect schools to the correct login page
            if ($request->is('School/*')) {
                return route('School.login');
            }
            return route('login'); // Default login route
        }
    }
}
