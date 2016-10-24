<?php

namespace App\Providers;

use App\Services\FooService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Foo', function ($app) {
            return new FooService($app['App\Services\BarService']);
        });
//        $this->app->bind('Foo', FooService::class);
    }
}
