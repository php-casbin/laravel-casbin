# Laravel-Casbin
Use Casbin in Laravel


#### Installation

Require this package in the `composer.json` of your Laravel project. This will download the package.

```
composer require casbin/laravel-adapter
```

The `CasbinAdapter\Laravel\CasbinServiceProvider` is `auto-discovered` and registered by default, but if you want to register it yourself:

Add the ServiceProvider in `config/app.php`

```php
'providers' => [
    /*
     * Package Service Providers...
     */
    CasbinAdapter\Laravel\CasbinServiceProvider::class,
]
```

The Casbin facade is also `auto-discovered`, but if you want to add it manually:

Add the Facade in `config/app.php`

```php
'aliases' => [
    // ...
    'Casbin' => CasbinAdapter\Laravel\Facades\Casbin::class,
]
```

To publish the config, run the vendor publish command:

```
php artisan vendor:publish
```

This will create a new model config file named `config/casbin-basic-model.conf`.


To migrate the migrations, run the migrate command:

```
php artisan migrate
```

This will create a new table named `casbin_rule`


#### Usage

```php

use \Casbin;

$sub = "alice"; // the user that wants to access a resource.
$obj = "data1"; // the resource that is going to be accessed.
$act = "read"; // the operation that the user performs on the resource.

if (Casbin::enforce($sub, $obj, $act) === true) {
    // permit alice to read data1x
} else {
    // deny the request, show an error
}

```

#### Define your own model.conf

You can modify the config file named `config/casbin-basic-model.conf`

#### Learning Casbin

You can find the full documentation of Casbin [on the website](https://www.baidu.com/).