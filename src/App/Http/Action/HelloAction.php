<?php

namespace App\Http\Action;

use Framework\Template\TemplateRenderer;
use Zend\Diactoros\Response\HtmlResponse;

class HelloAction
{
    private $template;

    public function __construct(TemplateRenderer $template)
    {
        $this->template = $template;
    }

    public function __invoke()
    {
        return new HtmlResponse($this->template->render('app/hello'));
    }
}
