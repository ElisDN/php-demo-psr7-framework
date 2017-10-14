<?php

namespace Infrastructure\Framework\Http\Router;

use Aura\Router\RouterContainer;
use Framework\Http\Router\AuraRouterAdapter;
use Interop\Container\ContainerInterface;

class AuraRouterFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new AuraRouterAdapter(new RouterContainer());
    }
}
