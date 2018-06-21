<?php

use App\Console\Command;
use Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator;
use Infrastructure\Framework\Http\Middleware\ErrorHandler\WhoopsErrorResponseGeneratorFactory;
use Infrastructure\Framework\Http\Middleware\ErrorHandler\WhoopsRunFactory;

return [
    'dependencies' => [
        'factories' => [
            ErrorResponseGenerator::class => WhoopsErrorResponseGeneratorFactory::class,
            Whoops\RunInterface::class => WhoopsRunFactory::class,
            Command\FixtureCommand::class => Infrastructure\App\Console\Command\FixtureCommandFactory::class,
        ],
    ],

    'console' => [
        'commands' => [
            Command\FixtureCommand::class,
        ],
    ],

    'doctrine' => [
        'configuration' => [
            'orm_default' => [
                'result_cache' => 'array',
                'metadata_cache' => 'array',
                'query_cache' => 'array',
                'hydration_cache' => 'array',
            ],
        ],
        'driver' => [
            'entities' => [
                'cache' => 'array',
            ],
        ],
    ],

    'debug' => true,
];