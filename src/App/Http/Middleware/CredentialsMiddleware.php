<?php

namespace App\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CredentialsMiddleware
{
    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        /** @var ResponseInterface $response */
        $response = $next($request);
        return $response->withHeader('X-Developer', 'ElisDN');
    }
}
