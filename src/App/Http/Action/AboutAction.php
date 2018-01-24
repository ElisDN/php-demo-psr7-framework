<?php

namespace App\Http\Action;

use Zend\Diactoros\Response\HtmlResponse;

/**
 * Class AboutAction
 *
 * @package App\Http\Action
 */
class AboutAction
{
    /**
     * @return HtmlResponse
     * @throws \InvalidArgumentException
     */
    public function __invoke()
    {
        return new HtmlResponse('I am a simple site');
    }
}
