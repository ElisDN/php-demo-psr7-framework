<?php

namespace Tests\Framework\Http;

use PHPUnit\Framework\TestCase;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\HtmlResponse;

class ResponseTest extends TestCase
{
    public function testEmpty(): void
    {
        $response = new HtmlResponse($body = 'Body');

        self::assertEquals($body, $response->getBody()->getContents());
        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals('OK', $response->getReasonPhrase());
    }

    public function test404(): void
    {
        $response = new HtmlResponse($body = 'Empty', $status = 404);

        self::assertEquals($body, $response->getBody()->getContents());
        self::assertEquals(mb_strlen($body), $response->getBody()->getSize());
        self::assertEquals($status, $response->getStatusCode());
        self::assertEquals('Not Found', $response->getReasonPhrase());
    }

    public function testHeaders(): void
    {
        $response = (new Response())
            ->withHeader($name1 = 'X-Header-1', $value1 = 'value_1')
            ->withHeader($name2 = 'X-Header-2', $value2 = 'value_2');

        self::assertEquals([$name1 => [$value1], $name2 => [$value2]], $response->getHeaders());
    }
}