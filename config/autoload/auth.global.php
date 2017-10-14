<?php

use App\Http\Middleware\BasicAuthMiddleware;
use Psr\Container\ContainerInterface;

return [
    'dependencies' => [
        'factories' => [
            BasicAuthMiddleware::class => function (ContainerInterface $container) {
                return new BasicAuthMiddleware($container->get('config')['auth']['users']);
            },
        ],
    ],

    'auth' => [
        'users' => [],
    ],
];
