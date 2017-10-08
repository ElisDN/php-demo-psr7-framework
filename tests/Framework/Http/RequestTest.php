<?php

namespace Tests\Framework\Http;

use Framework\Http\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testEmpty(): void
    {
        $_GET = [];
        $_POST = [];

        $request = new Request();

        self::assertEquals([], $request->getQueryParams());
        self::assertNull($request->getParsedBody());
    }

    public function testQueryParams(): void
    {
        $_GET = $data = [
            'name' => 'John',
            'age' => 28,
        ];
        $_POST = [];

        $request = new Request();

        self::assertEquals($data, $request->getQueryParams());
        self::assertNull($request->getParsedBody());
    }

    public function testParsedBody(): void
    {
        $_GET = [];
        $_POST = $data = ['title' => 'Title'];

        $request = new Request();

        self::assertEquals([], $request->getQueryParams());
        self::assertEquals($data, $request->getParsedBody());
    }
}