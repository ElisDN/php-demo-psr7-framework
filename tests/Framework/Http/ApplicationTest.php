<?php

namespace Tests\Framework\Http;

use Framework\Http\Application;
use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Router\Router;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\ServerRequest;

class ApplicationTest extends TestCase
{
    /**
     * @var MiddlewareResolver
     */
    private $resolver;
    /**
     * @var Router
     */
    private $router;

    public function setUp()
    {
        parent::setUp();
        $this->resolver = new MiddlewareResolver(new DummyContainer(), new Response());
        $this->router = $this->createMock(Router::class);
    }

    public function testPipe(): void
    {
        $app = new Application($this->resolver, $this->router, new DefaultHandler(), new Response());

        $app->pipe(new Middleware1());
        $app->pipe(new Middleware2());

        $response = $app->handle(new ServerRequest());

        $this->assertJsonStringEqualsJsonString(
            json_encode(['middleware-1' => 1, 'middleware-2' => 2]),
            $response->getBody()->getContents()
        );
    }
}

class Middleware1
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        return $next($request->withAttribute('middleware-1', 1));
    }
}

class Middleware2
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        return $next($request->withAttribute('middleware-2', 2));
    }
}

class DefaultHandler
{
    public function __invoke(ServerRequestInterface $request)
    {
        return new JsonResponse($request->getAttributes());
    }
}