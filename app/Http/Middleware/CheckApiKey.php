<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $providedKey = $request->header('X-Api-Key');
        $validKey = config('app.api_key');

        if (!$providedKey || $providedKey !== $validKey) {
            return response()->json([
                'message' => 'Invalid or missing API key',
            ]);
        }

        return $next($request);
    }
}
