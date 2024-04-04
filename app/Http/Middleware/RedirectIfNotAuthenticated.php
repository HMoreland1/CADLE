<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RedirectIfNotAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            // Set a flash message to be displayed
            Session::flash('toast', 'Please login to access this page.');

            // Redirect to the welcome page
            return redirect()->route('welcome'); // Adjust the route name according to your application
        }

        return $next($request);
    }
}
