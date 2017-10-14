<?php

use App\Http\Action;
use App\Http\Middleware;
use Framework\Http\Application;
use Framework\Container\Container;
use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Router\AuraRouterAdapter;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

### Configuration

$container = new Container();

$container->set('config', [
    'debug' => true,
    'users' => ['admin' => 'password'],
]);

$container->set('middleware.basic_auth', function (Container $container) {
    return new Middleware\BasicAuthMiddleware($container->get('config')['users']);
});

$container->set('middleware.error_handler', function (Container $container) {
    return new Middleware\ErrorHandlerMiddleware($container->get('config')['debug']);
});

### Initialization

$aura = new Aura\Router\RouterContainer();
$routes = $aura->getMap();

$routes->get('home', '/', Action\HelloAction::class);
$routes->get('about', '/about', Action\AboutAction::class);
$routes->get('cabinet', '/cabinet', Action\CabinetAction::class);
$routes->get('blog', '/blog', Action\Blog\IndexAction::class);
$routes->get('blog_show', '/blog/{id}', Action\Blog\ShowAction::class)->tokens(['id' => '\d+']);

$router = new AuraRouterAdapter($aura);

$resolver = new MiddlewareResolver();
$app = new Application($resolver, new Middleware\NotFoundHandler(), new Response());

$app->pipe($container->get('middleware.error_handler'));
$app->pipe(Middleware\CredentialsMiddleware::class);
$app->pipe(Middleware\ProfilerMiddleware::class);
$app->pipe(new Framework\Http\Middleware\RouteMiddleware($router));
$app->pipe('cabinet', $container->get('middleware.basic_auth'));
$app->pipe(new Framework\Http\Middleware\DispatchMiddleware($resolver));

### Running

$request = ServerRequestFactory::fromGlobals();
$response = $app->run($request, new Response());

### Sending

$emitter = new SapiEmitter();
$emitter->emit($response);
