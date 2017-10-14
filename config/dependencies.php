<?php

use App\Http\Middleware;
use Framework\Container\Container;
use Framework\Http\Application;
use Framework\Http\Middleware\DispatchMiddleware;
use Framework\Http\Middleware\RouteMiddleware;
use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Router\Router;

/** @var Container $container */

$container->set(Application::class, function (Container $container) {
    return new Application(
        $container->get(MiddlewareResolver::class),
        $container->get(Framework\Http\Router\Router::class),
        new Middleware\NotFoundHandler(),
        new Zend\Diactoros\Response()
    );
});

$container->set(Router::class, function () {
    return new AuraRouterAdapter(new Aura\Router\RouterContainer());
});

$container->set(MiddlewareResolver::class, function () {
    return new MiddlewareResolver();
});

$container->set(Middleware\BasicAuthMiddleware::class, function (Container $container) {
    return new Middleware\BasicAuthMiddleware($container->get('config')['users']);
});

$container->set(Middleware\ErrorHandlerMiddleware::class, function (Container $container) {
    return new Middleware\ErrorHandlerMiddleware($container->get('config')['debug']);
});

$container->set(DispatchMiddleware::class, function (Container $container) {
    return new DispatchMiddleware($container->get(MiddlewareResolver::class));
});

$container->set(RouteMiddleware::class, function (Container $container) {
    return new RouteMiddleware($container->get(Router::class));
});
