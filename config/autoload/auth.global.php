<?php

use App\Http\Middleware;

return [
    'dependencies' => [
        'factories' => [
            Middleware\BasicAuthMiddleware::class => Infrastructure\App\Http\Middleware\BasicAuthMiddlewareFactory::class,
        ],
    ],

    'auth' => [
        'users' => [],
    ],
];
