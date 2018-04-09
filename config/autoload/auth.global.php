<?php

use App\Http\Middleware\BasicAuthMiddleware;
use Psr\Container\ContainerInterface;
use Zend\Diactoros\Response;

return [
    'dependencies' => [
        'factories' => [
            BasicAuthMiddleware::class => function (ContainerInterface $container) {
                return new BasicAuthMiddleware($container->get('config')['auth']['users'], new Response());
            },
        ],
    ],

    'auth' => [
        'users' => [],
    ],
];
