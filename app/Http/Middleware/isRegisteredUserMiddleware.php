<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isRegisteredUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ((!auth()->check()) || (auth()->user()->role != 'registered_user')) {
            // Forza l'uso della vista personalizzata senza passare per il sistema di errori di Laravel
            return response()
                ->view('errors.403', ['exception' => null], 403)
                ->header('Content-Type', 'text/html');
        }
        return $next($request);
    }
}
