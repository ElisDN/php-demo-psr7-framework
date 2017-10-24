<?php

namespace Tests\Framework\Http\Middleware\ErrorHandler;

use Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware;
use Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequest;

class ErrorHandlerTest extends TestCase
{
    public function testNone(): void
    {
        $handler = new ErrorHandlerMiddleware(new DummyGenerator());
        $response = $handler->process(new ServerRequest(), new CorrectAction());

        self::assertEquals('Content', $response->getBody()->getContents());
        self::assertEquals(200, $response->getStatusCode());
    }

    public function testException(): void
    {
        $handler = new ErrorHandlerMiddleware(new DummyGenerator());
        $response = $handler->process(new ServerRequest(), new ErrorAction());

        self::assertEquals('Runtime Error', $response->getBody()->getContents());
        self::assertEquals(500, $response->getStatusCode());
    }
}

class DummyGenerator implements ErrorResponseGenerator
{
    public function generate(\Throwable $e, ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse($e->getMessage(), 500);
    }
}

class CorrectAction implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse('Content');
    }
}

class ErrorAction implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        throw new \RuntimeException('Runtime Error');
    }
}