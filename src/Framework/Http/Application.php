<?php

namespace Framework\Http;

use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Router\RouteData;
use Framework\Http\Router\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Stratigility\MiddlewarePipe;

/**
 * Class Application
 *
 * @package Framework\Http
 */
class Application extends MiddlewarePipe
{
    /**
     * @var MiddlewareResolver
     */
    private $resolver;
    /**
     * @var Router
     */
    private $router;
    /**
     * @var callable
     */
    private $default;

    /**
     * Application constructor.
     *
     * @param MiddlewareResolver $resolver
     * @param Router             $router
     * @param callable           $default
     * @param ResponseInterface  $responsePrototype
     */
    public function __construct(MiddlewareResolver $resolver, Router $router, callable $default, ResponseInterface $responsePrototype)
    {
        parent::__construct();
        $this->resolver = $resolver;
        $this->router = $router;
        $this->setResponsePrototype($responsePrototype);
        $this->default = $default;
    }

    /**
     * @param callable|object|string $path
     * @param null                   $middleware
     *
     * @return MiddlewarePipe
     */
    public function pipe($path, $middleware = null): MiddlewarePipe
    {
        if ($middleware === null) {
            return parent::pipe($this->resolver->resolve($path, $this->responsePrototype));
        }
        return parent::pipe($path, $this->resolver->resolve($middleware, $this->responsePrototype));
    }

    /**
     * @param       $name
     * @param       $path
     * @param       $handler
     * @param array $methods
     * @param array $options
     */
    private function route($name, $path, $handler, array $methods, array $options = []): void
    {
        $this->router->addRoute(new RouteData($name, $path, $handler, $methods, $options));
    }

    /**
     * @param       $name
     * @param       $path
     * @param       $handler
     * @param array $options
     */
    public function any($name, $path, $handler, array $options = []): void
    {
        $this->route($name, $path, $handler, $options);
    }

    /**
     * @param       $name
     * @param       $path
     * @param       $handler
     * @param array $options
     */
    public function get($name, $path, $handler, array $options = []): void
    {
        $this->route($name, $path, $handler, ['GET'], $options);
    }

    /**
     * @param       $name
     * @param       $path
     * @param       $handler
     * @param array $options
     */
    public function post($name, $path, $handler, array $options = []): void
    {
        $this->route($name, $path, $handler, ['POST'], $options);
    }

    /**
     * @param       $name
     * @param       $path
     * @param       $handler
     * @param array $options
     */
    public function put($name, $path, $handler, array $options = []): void
    {
        $this->route($name, $path, $handler, ['PUT'], $options);
    }

    /**
     * @param       $name
     * @param       $path
     * @param       $handler
     * @param array $options
     */
    public function patch($name, $path, $handler, array $options = []): void
    {
        $this->route($name, $path, $handler, ['PATCH'], $options);
    }

    /**
     * @param       $name
     * @param       $path
     * @param       $handler
     * @param array $options
     */
    public function delete($name, $path, $handler, array $options = []): void
    {
        $this->route($name, $path, $handler, ['DELETE'], $options);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     *
     * @return ResponseInterface
     */
    public function run(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this($request, $response, $this->default);
    }
}
