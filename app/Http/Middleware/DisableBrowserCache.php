<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DisableBrowserCache
{
    /**
     * Sets a cache control header to disable browser caching.
     *
     * For some reason `ResponseHeaderBag::computeCacheControlValue` insists on
     * making changing to the `Cache-Control` header even though it is modified
     * using the `cache.headers` middleware. This middleware removes the header
     * entirely and sets it to a value to prevent browser caching.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     *
     * @see \Symfony\Component\HttpFoundation\ResponseHeaderBag::computeCacheControlValue()
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $response = $next($request);
        $response->headers->set('Cache-Control', 'no-cache, no-store');
        return $response;
    }
}
