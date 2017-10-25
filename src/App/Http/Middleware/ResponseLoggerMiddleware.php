<?php

namespace App\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

class ResponseLoggerMiddleware implements MiddlewareInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        $code = $response->getStatusCode();

        if ($code >= 400 && $code < 600) {
            $this->logger->error($response->getReasonPhrase(), [
                'method' => $request->getMethod(),
                'url' => (string)$request->getUri(),
            ]);
        }

        return $response;
    }
}
