<?php

namespace Framework\Http;

use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Router\RouteData;
use Framework\Http\Router\Router;
use Interop\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Webimpress\HttpMiddlewareCompatibility\HandlerInterface as RequestHandlerInterface;
use Zend\Stratigility\MiddlewarePipe;

class Application implements MiddlewareInterface, RequestHandlerInterface
{
    private $resolver;
    private $router;
    private $default;
    private $pipeline;
    private $responsePrototype;

    public function __construct(MiddlewareResolver $resolver, Router $router, callable $default, ResponseInterface $responsePrototype)
    {
        $this->resolver = $resolver;
        $this->router = $router;
        $this->pipeline = new MiddlewarePipe();
        $this->pipeline->setResponsePrototype($responsePrototype);
        $this->default = $default;
        $this->responsePrototype = $responsePrototype;
    }

    public function pipe($path, $middleware = null): MiddlewarePipe
    {
        if ($middleware === null) {
            return $this->pipeline->pipe($this->resolver->resolve($path));
        }
        return $this->pipeline->pipe($path, $this->resolver->resolve($middleware));
    }

    private function route($name, $path, $handler, array $methods, array $options = []): void
    {
        $this->router->addRoute(new RouteData($name, $path, $handler, $methods, $options));
    }

    public function any($name, $path, $handler, array $options = []): void
    {
        $this->route($name, $path, $handler, $options);
    }

    public function get($name, $path, $handler, array $options = []): void
    {
        $this->route($name, $path, $handler, ['GET'], $options);
    }

    public function post($name, $path, $handler, array $options = []): void
    {
        $this->route($name, $path, $handler, ['POST'], $options);
    }

    public function put($name, $path, $handler, array $options = []): void
    {
        $this->route($name, $path, $handler, ['PUT'], $options);
    }

    public function patch($name, $path, $handler, array $options = []): void
    {
        $this->route($name, $path, $handler, ['PATCH'], $options);
    }

    public function delete($name, $path, $handler, array $options = []): void
    {
        $this->route($name, $path, $handler, ['DELETE'], $options);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return ($this->pipeline)($request, $this->responsePrototype, $this->default);
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next): ResponseInterface
    {
        return ($this->pipeline)($request, $response, $next);
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $this->pipeline->process($request, $handler);
    }
}
