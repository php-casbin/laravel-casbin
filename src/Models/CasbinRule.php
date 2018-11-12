<?php

namespace CasbinAdapter\Laravel\Models;

use Illuminate\Database\Eloquent\Model;

class CasbinRule extends Model
{
    protected $fillable = ['ptype', 'v0', 'v1', 'v2', 'v3', 'v4', 'v5'];

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $connection = config('casbin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('casbin.database.casbin_rules_table'));

        parent::__construct($attributes);
    }
}
