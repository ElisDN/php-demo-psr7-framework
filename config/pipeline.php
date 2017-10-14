<?php

use App\Http\Middleware;

/** @var \Framework\Http\Application $app */

$app->pipe(Middleware\ErrorHandlerMiddleware::class);
$app->pipe(Middleware\CredentialsMiddleware::class);
$app->pipe(Middleware\ProfilerMiddleware::class);
$app->pipe(Framework\Http\Middleware\RouteMiddleware::class);

$app->pipe('cabinet', Middleware\BasicAuthMiddleware::class);

$app->pipe(Framework\Http\Middleware\DispatchMiddleware::class);

