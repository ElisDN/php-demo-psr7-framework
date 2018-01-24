<?php

namespace Framework\Http\Middleware;

use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Router\Result;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class DispatchMiddleware
 *
 * @package Framework\Http\Middleware
 */
class DispatchMiddleware
{
    private $resolver;

    /**
     * DispatchMiddleware constructor.
     *
     * @param MiddlewareResolver $resolver
     */
    public function __construct(MiddlewareResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable               $next
     *
     * @return mixed
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        /** @var Result $result */
        if (!$result = $request->getAttribute(Result::class)) {
            return $next($request);
        }
        $middleware = $this->resolver->resolve($result->getHandler(), $response);
        return $middleware($request, $response, $next);
    }
}
