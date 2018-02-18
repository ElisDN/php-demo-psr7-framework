<?php

namespace Framework\Template\Php\Extension;

use Framework\Http\Router\Router;
use Framework\Template\Php\Extension;
use Framework\Template\Php\SimpleFunction;

class RouteExtension extends Extension
{
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function getFunctions(): array
    {
        return [
            new SimpleFunction('path', [$this, 'generatePath']),
        ];
    }

    public function generatePath($name, array $params = []): string
    {
        return $this->router->generate($name, $params);
    }
}
