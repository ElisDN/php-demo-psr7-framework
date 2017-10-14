<?php

namespace Infrastructure\Framework\Http\Middleware\ErrorHandler;

use Framework\Http\Middleware\ErrorHandler\WhoopsErrorResponseGenerator;
use Psr\Container\ContainerInterface;
use Whoops\RunInterface;
use Zend\Diactoros\Response;

class WhoopsErrorResponseGeneratorFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new WhoopsErrorResponseGenerator(
            $container->get(RunInterface::class),
            new Response()
        );
    }
}
