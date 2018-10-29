<?php
namespace CasbinAdapter\Laravel;

use CasbinAdapter\Laravel\Adapter;
use Casbin\Enforcer;
use Illuminate\Support\ServiceProvider;

class CasbinServiceProvider extends ServiceProvider
{

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/../database/migrations' => database_path('migrations')], 'laravel-casbin-migrations');
            $this->publishes([__DIR__ . '/../config/casbin-basic-model.conf' => config_path('casbin-basic-model.conf')], 'config');
        }
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('casbin', function () {
            return new Enforcer(
                config_path('casbin-basic-model.conf'),
                $this->app->make(Adapter::class)
            );
        });
    }
}
