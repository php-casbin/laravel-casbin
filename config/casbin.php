<?php

return [
    /*
     * Laravel-casbin model setting.
     */
    'model' => [
        // Available Settings: "file", "text"
        'config_type' => 'file',

        'config_file_path' => config_path('casbin-basic-model.conf'),

        'config_text' => '',
    ],

    // Laravel-casbin adapter .
    'adapter' => CasbinAdapter\Laravel\Adapter::class,

    /*
     * Laravel-casbin database setting.
     */
    'database' => [
        // Database connection for following tables.
        'connection' => '',

        // CasbinRule tables and model.
        'casbin_rules_table' => 'casbin_rule',
    ],
];
