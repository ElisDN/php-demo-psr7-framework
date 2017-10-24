<?php

namespace Framework\Http\Middleware\ErrorHandler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface ErrorResponseGenerator
{
    public function generate(\Throwable $e, ServerRequestInterface $request): ResponseInterface;
}
