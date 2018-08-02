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
        Passport::routes();
    }
}
