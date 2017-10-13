<?php

namespace Framework\Http\Pipeline;

use Interop\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;

class InteropHandlerWrapper implements RequestHandlerInterface
{
    private $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function handle(ServerRequestInterface $request)
    {
        return ($this->callback)($request);
    }
}
