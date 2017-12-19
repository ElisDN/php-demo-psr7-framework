<?php

use App\Http\Action;
use App\Http\Middleware;
use Framework\Http\Application;
use Framework\Http\Middleware\DispatchMiddleware;
use Framework\Http\Middleware\RouteMiddleware;
use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Router\Router;
use Psr\Container\ContainerInterface;

return [
    'dependencies' => [
        'invokables' => [
            Middleware\CredentialsMiddleware::class,
            Middleware\ProfilerMiddleware::class,
            Action\HelloAction::class,
            Action\AboutAction::class,
            Action\CabinetAction::class,
            Action\Blog\IndexAction::class,
            Action\Blog\ShowAction::class,
        ],
        'factories' => [
            Application::class => function (ContainerInterface $container) {
                return new Application(
                    $container->get(MiddlewareResolver::class),
                    $container->get(Framework\Http\Router\Router::class),
                    new Middleware\NotFoundHandler(),
                    new Zend\Diactoros\Response()
                );
            },
            Router::class => function () {
                return new AuraRouterAdapter(new Aura\Router\RouterContainer());
            },
            MiddlewareResolver::class => function (ContainerInterface $container) {
                return new MiddlewareResolver($container);
            },
            Middleware\BasicAuthMiddleware::class => function (ContainerInterface $container) {
                return new Middleware\BasicAuthMiddleware($container->get('config')['users']);
            },
            Middleware\ErrorHandlerMiddleware::class => function (ContainerInterface $container) {
                return new Middleware\ErrorHandlerMiddleware($container->get('config')['debug']);
            },
            DispatchMiddleware::class => function (ContainerInterface $container) {
                return new DispatchMiddleware($container->get(MiddlewareResolver::class));
            },
            RouteMiddleware::class => function (ContainerInterface $container) {
                return new RouteMiddleware($container->get(Router::class));
            },
        ],
    ],
];
