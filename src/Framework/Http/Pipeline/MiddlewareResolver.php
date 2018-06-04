<?php

namespace Framework\Http\Pipeline;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Stratigility\Middleware\DoublePassMiddlewareDecorator;
use Zend\Stratigility\Middleware\RequestHandlerMiddleware;
use Zend\Stratigility\MiddlewarePipe;

class MiddlewareResolver
{
    private $container;
    private $responsePrototype;

    public function __construct(ContainerInterface $container, ResponseInterface $responsePrototype)
    {
        $this->container = $container;
        $this->responsePrototype = $responsePrototype;
    }

    public function resolve($handler): MiddlewareInterface
    {
        if (\is_array($handler)) {
            return $this->createPipe($handler);
        }

        if (\is_string($handler) && $this->container->has($handler)) {
            return new LazyMiddlewareDecorator($this, $this->container, $handler);
        }

        if ($handler instanceof MiddlewareInterface) {
            return $handler;
        }

        if ($handler instanceof RequestHandlerInterface) {
            return new RequestHandlerMiddleware($handler);
        }

        if (\is_object($handler)) {
            $reflection = new \ReflectionObject($handler);
            if ($reflection->hasMethod('__invoke')) {
                $method = $reflection->getMethod('__invoke');
                $parameters = $method->getParameters();
                if (\count($parameters) === 2 && $parameters[1]->isCallable()) {
                    return new SinglePassMiddlewareDecorator($handler);
                }
                return new DoublePassMiddlewareDecorator($handler, $this->responsePrototype);
            }
        }

        throw new UnknownMiddlewareTypeException($handler);
    }

    private function createPipe(array $handlers): MiddlewarePipe
    {
        $pipeline = new MiddlewarePipe();
        foreach ($handlers as $handler) {
            $pipeline->pipe($this->resolve($handler));
        }
        return $pipeline;
    }
}
