<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect('login');
        }
        
        // Check if user is admin
        if (Auth::user()->role === 'admin') {
            return $next($request);
        }
        
        // Check if admin guard is active
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }
        
        // Redirect to home if not admin
        return redirect('/')->with('error', 'You do not have admin access');
    }
}