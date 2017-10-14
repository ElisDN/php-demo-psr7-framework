<?php

use Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator;
use Infrastructure\Framework\Http\Middleware\ErrorHandler\WhoopsErrorResponseGeneratorFactory;
use Infrastructure\Framework\Http\Middleware\ErrorHandler\WhoopsRunFactory;

return [
    'dependencies' => [
        'factories' => [
            ErrorResponseGenerator::class => WhoopsErrorResponseGeneratorFactory::class,
            Whoops\RunInterface::class => WhoopsRunFactory::class,
        ],
    ],

    'debug' => true,
];