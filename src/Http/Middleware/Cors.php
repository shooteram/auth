<?php

namespace shooteram\Auth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $origin = $request->headers->get('Origin');

        if (!$origin) {
            $message = "Requests to this endpoint requires an \"Origin\" header.";

            return response($message, 403);
        }

        if (!$this->originIsAllowed($origin)) {
            $message = "This domain origin is not whitelisted to perform CORS requests to
                this server.";

            return response($message, 403);
        }

        $headers = [
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Allow-Headers' => $this->getHeaders(),
            'Access-Control-Allow-Origin' => $this->getOrigin($origin),
            'Access-Control-Allow-Methods' => $this->getAllowedMethods(),
        ];

        if ($request->method() === 'OPTIONS') {
            return response(null, 200)->withHeaders($headers);
        }

        return $next($request)->withHeaders($headers);
    }

    private function originIsAllowed(string $origin) : bool
    {
        return $this->getOrigin($origin) === false ? false : true;
    }

    private function getOrigin(string $origin)
    {
        $whiteListedOrigins = collect(config('cors.allowed-origins'));

        if (env('CORS_ALLOWED_ORIGINS')) {
            $allowedOriginsFromEnv = explode(',', env('CORS_ALLOWED_ORIGINS'));

            $whiteListedOrigins = $whiteListedOrigins->merge($allowedOriginsFromEnv);
        }

        return ! $whiteListedOrigins->contains($origin) ? false : $origin;
    }

    private function getHeaders() : string
    {
        return implode(', ', config('cors.allowed-headers'));
    }

    private function getAllowedMethods() : string
    {
        return implode(', ', config('cors.allowed-methods'));
    }
}
