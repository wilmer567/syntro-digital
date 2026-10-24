<?php

namespace App\Http\Middleware;

use App\Models\Visit;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisit
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only track successful GET responses
        if ($request->isMethod('GET') && $response->isSuccessful()) {
            // Do not track authenticated admins browsing the site
            if (! auth()->check()) {
                try {
                    Visit::record($request);
                } catch (\Throwable $e) {
                    report($e);
                }
            }
        }

        return $response;
    }
}
