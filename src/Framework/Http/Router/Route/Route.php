<?php

namespace Framework\Http\Router\Route;

use Framework\Http\Router\Result;
use Psr\Http\Message\ServerRequestInterface;

interface Route
{
    public function match(ServerRequestInterface $request): ?Result;

    public function generate($name, array $params = []): ?string;
}