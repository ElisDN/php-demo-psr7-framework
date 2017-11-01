<?php

require 'vendor/autoload.php';

/** @var \Interop\Container\ContainerInterface $container */
$container = require 'config/container.php';

return [
    'environments' =>  [
        'default_migration_table' => 'migrations',
        'default_database' => 'app',
        'app' => [
            'name' => $container->get('config')['phinx']['database'],
            'connection' => $container->get(PDO::class),
        ],
    ],
    'paths' => [
        'migrations' => 'db/migrations',
        'seeds' =>  'db/seeds',
    ],
];