<?php

namespace shooteram\Auth\Http\Middleware;

use Closure;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $origin = $request->headers->get('Origin');

        if (! $origin)
            return response('Requests to this endpoint requires an "Origin" header.', 403);

        if (! $this->originIsAllowed($origin))
            return response('This domain origin is not whitelisted to perform CORS requests to this server.', 403);

        $headers = collect([
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Allow-Headers' => $this->getHeaders(),
            'Access-Control-Allow-Origin' => $this->getOrigin($origin),
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
        ]);

        if ($request->method() === 'OPTIONS')
            return response(null, 200)->withHeaders($headers);

        return $next($request)->withHeaders($headers);
    }

    private function originIsAllowed($origin): bool
    {
        return $this->getOrigin($origin) ===  false ? false : true;
    }

    private function getOrigin($origin)
    {
        $whiteListedOrigins = collect(
            config('cors.allowed-origins')
        );

        return ! $whiteListedOrigins->contains($origin) ? false : $origin;
    }

    private function getHeaders(): string
    {
        return implode(', ', config('cors.allowed-headers'));
    }
}
