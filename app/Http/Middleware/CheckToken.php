<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Retrieve the token from the request headers
        $token = $request->header('token');

        // Check if the token matches 'vg@123'
        if ($token !== 'vg@123') {
            // If the token is invalid, return a 403 Forbidden response
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // If the token is valid, proceed with the request
        return $next($request);
    }
}
