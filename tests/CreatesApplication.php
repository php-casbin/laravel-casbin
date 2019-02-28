<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use CasbinAdapter\Laravel\Models\CasbinRule;

trait CreatesApplication
{

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../vendor/laravel/laravel/bootstrap/app.php';

        $app->booting(function () {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Casbin', \CasbinAdapter\Laravel\Facades\Casbin::class);
        });

        $app->make(Kernel::class)->bootstrap();
        $app->register(\CasbinAdapter\Laravel\CasbinServiceProvider::class);

        $app['config']->set('database.default', 'mysql');
        $app['config']->set('database.connections.mysql.charset', 'utf8');
        $app['config']->set('database.connections.mysql.collation', 'utf8_unicode_ci');

        $app['config']->set('casbin.model.config_type', 'text');
        $text = <<<'EOT'
[request_definition]
r = sub, obj, act

[policy_definition]
p = sub, obj, act

[role_definition]
g = _, _

[policy_effect]
e = some(where (p.eft == allow))

[matchers]
m = g(r.sub, p.sub) && r.obj == p.obj && r.act == p.act
EOT;
        $app['config']->set('casbin.model.config_text', $text);
        // $app['config']->set('casbin.log.enabled', true);

        $this->app = $app;
        $this->artisan('vendor:publish', ['--provider' => 'CasbinAdapter\Laravel\CasbinServiceProvider']);
        $this->artisan('migrate', ['--force' => true]);

        if (method_exists($this, 'afterApplicationCreated')) {
            $this->afterApplicationCreated(function () {
                $this->initTable();
            });
        } else {
            $this->initTable();
        }

        return $this->app;
    }

    protected function initTable()
    {
        CasbinRule::truncate();

        CasbinRule::create(['ptype' => 'p', 'v0' => 'alice', 'v1' => 'data1', 'v2' => 'read']);
        CasbinRule::create(['ptype' => 'p', 'v0' => 'bob', 'v1' => 'data2', 'v2' => 'write']);

        CasbinRule::create(['ptype' => 'p', 'v0' => 'data2_admin', 'v1' => 'data2', 'v2' => 'read']);
        CasbinRule::create(['ptype' => 'p', 'v0' => 'data2_admin', 'v1' => 'data2', 'v2' => 'write']);
        CasbinRule::create(['ptype' => 'g', 'v0' => 'alice', 'v1' => 'data2_admin']);
    }
}
