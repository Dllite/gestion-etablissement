<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Controller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && (auth()->user()->role_id === 2 || auth()->user()->role_id === 1) ) {
            return $next($request);
        }

        return redirect()->back()->with("warning", "Seuls l'administrateur et les comptables ont accès à ceci");
    }
}
