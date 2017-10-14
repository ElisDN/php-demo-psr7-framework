<?php

namespace Infrastructure\App\Http\Middleware;

use App\Http\Middleware\BasicAuthMiddleware;
use Psr\Container\ContainerInterface;
use Zend\Diactoros\Response;

class BasicAuthMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new BasicAuthMiddleware($container->get('config')['auth']['users'], new Response());
    }
}
