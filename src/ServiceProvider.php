<?php

namespace shooteram\Auth;

use Laravel\Passport\HasApiTokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/cors.php' => config_path('cors.php')
        ], 'config');

        $hasApiTokensClass = HasApiTokens::class;
        $userClass = config('auth.providers.users.model');
        if (! array_key_exists($hasApiTokensClass, class_uses($userClass))) {
            throw new \Exception("Use the trait $hasApiTokensClass for your auth provider user model ($userClass) class.");
        }

        $this->mergeConfigFrom(__DIR__ . '/../config/cors.php', 'cors');
        $this->defineRoutes();
    }

    protected function defineRoutes()
    {
        $middlewares = collect([
            \shooteram\Auth\Http\Middleware\Cors::class,
            $this->getThrottle(),
            'web',
        ]);

        $namespace = '\shooteram\Auth\Http\Controllers';

        Route::match($this->preflight('get'), 'home', "$namespace\HomeController@home")->name('home')
            ->middleware('auth:api');
        Route::match($this->preflight('get'), 'csrf', "$namespace\DefaultController@getCsrfToken")
            ->middleware($middlewares->all());

        $options = [
            'prefix' => 'auth',
            'middleware' => $middlewares->merge(['guest'])->all(),
            'namespace' => "$namespace\Auth",
        ];

        Route::group($options, function () use ($middlewares) {
            Route::group(['middleware' => ['guest', 'web']], function () {
                Route::match($this->preflight('post'), 'login', 'LoginController@login');
                Route::match($this->preflight('get'), 'login', 'LoginController@display')->name('login');
                Route::match($this->preflight('post'), 'register', 'RegisterController@register');
            });

            Route::match($this->preflight('post'), 'logout', 'LogoutController@logout')
                ->middleware($middlewares->merge(['auth'])->all());
        });

        Route::match($this->preflight('get'), '/api/user', function (Request $request) {
            return $request->user();
        })->middleware($middlewares->merge(['auth'])->all());
    }

    private function preflight(string $method): array
    {
        return [$method, 'options'];
    }

    private function getThrottle(): string
    {
        $throttle = config(
            'cors.throttle',
            (object)['rate_limit' => 10, 'retry_after' => 1]
        );

        return sprintf(
            "throttle:%d,%d",
            $throttle->rate_limit,
            $throttle->retry_after
        );
    }
}
