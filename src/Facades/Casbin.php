<?php
namespace CasbinAdapter\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 *
 */
class Casbin extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'casbin';
    }
}
