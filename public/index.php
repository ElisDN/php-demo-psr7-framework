<?php

use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

### Initialization

$request = ServerRequestFactory::fromGlobals();

### Action

$path = $request->getUri()->getPath();
$action = null;

if ($path === '/') {

    $action = function (ServerRequestInterface $request) {
        $name = $request->getQueryParams()['name'] ?? 'Guest';
        return new HtmlResponse('Hello, ' . $name . '!');
    };

} elseif ($path === '/about') {

    $action = function () {
        return new HtmlResponse('I am a simple site');
    };

} elseif ($path === '/blog') {

    $action = function () {
        return new JsonResponse([
            ['id' => 2, 'title' => 'The Second Post'],
            ['id' => 1, 'title' => 'The First Post'],
        ]);
    };

} elseif (preg_match('#^/blog/(?P<id>\d+)$#i', $path, $matches)) {

    $request = $request->withAttribute('id', $matches['id']);

    $action = function (ServerRequestInterface $request) {
        $id = $request->getAttribute('id');
        if ($id > 2) {
            return new JsonResponse(['error' => 'Undefined page'], 404);
        }
        return new JsonResponse(['id' => $id, 'title' => 'Post #' . $id]);
    };

}

if ($action) {
    $response = $action($request);
} else {
    $response = new HtmlResponse('Undefined page', 404);
}

### Postprocessing

$response = $response->withHeader('X-Developer', 'ElisDN');

### Sending

$emitter = new SapiEmitter();
$emitter->emit($response);
