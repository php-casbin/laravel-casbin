<?php

namespace CasbinAdapter\Laravel;

use Casbin\Enforcer;
use Casbin\Model\Model;
use Illuminate\Support\ServiceProvider;
use Casbin\Log\Log;

class CasbinServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/casbin.php', 'casbin');
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__.'/../database/migrations' => database_path('migrations')], 'laravel-casbin-migrations');
            $this->publishes([__DIR__.'/../config/casbin-basic-model.conf' => config_path('casbin-basic-model.conf')], 'laravel-casbin-config');
            $this->publishes([__DIR__.'/../config/casbin.php' => config_path('casbin.php')], 'laravel-casbin-config');
        }
    }

    /**
     * Register bindings in the container.
     */
    public function register()
    {
        $this->app->bind('casbin', function () {
            $loggerEnable = config('casbin.log.enabled');
            $logger = config('casbin.log.logger');
            Log::setLogger(new $logger($this->app['log']));

            $model = new Model();
            $configType = config('casbin.model.config_type');
            if ('file' == $configType) {
                $model->loadModel(config('casbin.model.config_file_path'));
            } elseif ('text' == $configType) {
                $model->loadModelFromText(config('casbin.model.config_text'));
            }

            $adapter = config('casbin.adapter');
            return new Enforcer($model, $this->app->make($adapter), $loggerEnable);
        });
    }
}
