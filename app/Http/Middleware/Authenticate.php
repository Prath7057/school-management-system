<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{

    public function handle(Request $request, Closure $next, ...$guards): Response
    {

        $guards = empty($guards) ? [null] : $guards;
        //
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                Auth::shouldUse($guard);
                return $next($request);
            }
        }
        $this->unauthenticated($guards);
    }

    protected function unauthenticated(array $guards)
    {
        throw new AuthenticationException(
            'Unauthenticated',
            $guards,
            $this->redirectTo()
        );
    }

    protected function redirectTo() {

        if (Route::is('School.*')) {
            return route('School.login');
        }
          
     

        return route('login');

    }
}
