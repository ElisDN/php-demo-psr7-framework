<?php

namespace Infrastructure\Framework\Http\Middleware\ErrorHandler;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class LogErrorListener
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(\Throwable $e, ServerRequestInterface $request)
    {
        $this->logger->error($e->getMessage(), [
            'exception' => $e,
            'request' => self::extractRequest($request),
        ]);
    }

    private static function extractRequest(ServerRequestInterface $request): array
    {
        return [
            'method' => $request->getMethod(),
            'url' => (string)$request->getUri(),
            'server' => $request->getServerParams(),
            'cookies' => $request->getCookieParams(),
            'body' => $request->getParsedBody(),
        ];
    }
}
