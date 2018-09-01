<?php

namespace shooteram\Auth;

use Laravel\Passport\Passport;

class ServiceProvider extends \Illuminate\Support\ServiceProvider {
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
    private function preflight(string $method): array
    {
        return [$method, 'options'];
    }
    private function getThrottle(): string
    {
        $throttle = config('cors.throttle');

        $rate_limit = $throttle['rate_limit'];
        $retry_after = $throttle['retry_after'];

        return "throttle:$rate_limit,$retry_after";
    }
}
