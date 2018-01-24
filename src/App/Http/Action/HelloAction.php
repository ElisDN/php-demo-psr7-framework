<?php

namespace App\Http\Action;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;

/**
 * Class HelloAction
 *
 * @package App\Http\Action
 */
class HelloAction
{
    /**
     * @param ServerRequestInterface $request
     *
     * @return HtmlResponse
     * @throws \InvalidArgumentException
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $name = $request->getQueryParams()['name'] ?? 'Guest';

        return new HtmlResponse('Hello, ' . $name . '!');
    }
}
