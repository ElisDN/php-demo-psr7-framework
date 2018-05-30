<?php

use Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator;
use Framework\Http\Application;
use Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware;
use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Router\Router;

return [
    'dependencies' => [
        'abstract_factories' => [
            Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory::class,
        ],
        'factories' => [
            Application::class => Infrastructure\Framework\Http\ApplicationFactory::class,
            Router::class => Infrastructure\Framework\Http\Router\AuraRouterFactory::class,
            MiddlewareResolver::class => Infrastructure\Framework\Http\Pipeline\MiddlewareResolverFactory::class,
            ErrorHandlerMiddleware::class => Infrastructure\Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddlewareFactory::class,
            ErrorResponseGenerator::class => Infrastructure\Framework\Http\Middleware\ErrorHandler\PrettyErrorResponseGeneratorFactory::class,
            Psr\Log\LoggerInterface::class => Infrastructure\App\Logger\LoggerFactory::class,

            App\ReadModel\PostReadRepository::class => Infrastructure\App\ReadModel\PostReadRepositoryFactory::class
        ],
    ],

    'debug' => false,
];
