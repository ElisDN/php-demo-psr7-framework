<?php

namespace App\Http\Action;

use App\Http\Middleware\BasicAuthMiddleware;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;

/**
 * Class CabinetAction
 *
 * @package App\Http\Action
 */
class CabinetAction
{
    /**
     * @param ServerRequestInterface $request
     *
     * @return HtmlResponse
     * @throws \InvalidArgumentException
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $username = $request->getAttribute(BasicAuthMiddleware::ATTRIBUTE);

        return new HtmlResponse('I am logged in as ' . $username);
    }
}
