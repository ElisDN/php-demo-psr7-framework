<?php

namespace Tests\App\Http\Action\Blog;

use App\Http\Action\Blog\ShowAction;
use App\Http\Middleware\NotFoundHandler;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\ServerRequest;

class ShowActionTest extends TestCase
{
    public function testSuccess()
    {
        $action = new ShowAction();

        $request = (new ServerRequest())
            ->withAttribute('id', $id = 2);

        $response = $action($request, new NotFoundHandler());

        self::assertEquals(200, $response->getStatusCode());
        self::assertJsonStringEqualsJsonString(
            json_encode(['id' => $id, 'title' => 'Post #' . $id]),
            $response->getBody()->getContents()
        );
    }

    public function testNotFound()
    {
        $action = new ShowAction();

        $request = (new ServerRequest())
            ->withAttribute('id', $id = 10);

        $response = $action($request, function () {
            return new HtmlResponse('Not found', 404);
        });

        self::assertEquals(404, $response->getStatusCode());
        self::assertEquals('Not found', $response->getBody()->getContents());
    }
}
