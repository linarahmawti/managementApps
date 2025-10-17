<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OptimizePerformance
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Add cache headers for static assets
        if ($request->is('css/*') || $request->is('js/*') || $request->is('images/*')) {
            $response->headers->set('Cache-Control', 'public, max-age=31536000'); // 1 year
        }

        // Add compression hints
        if (!$response->headers->has('Content-Encoding')) {
            $response->headers->set('X-Compress-Hint', 'on');
        }

        return $response;
    }
}
