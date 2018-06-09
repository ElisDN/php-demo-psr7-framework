<?php

namespace App\Http\Middleware\ErrorHandler;

use Framework\Template\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Stratigility\Utils;

class PrettyErrorResponseGenerator implements ErrorResponseGenerator
{
    private $template;
    private $views;

    public function __construct(TemplateRenderer $template, array $views)
    {
        $this->template = $template;
        $this->views = $views;
    }

    public function generate(\Throwable $e, ServerRequestInterface $request): ResponseInterface
    {
        $code = Utils::getStatusCode($e, new Response());
        return new HtmlResponse($this->template->render($this->getView($code), [
            'request' => $request,
            'exception' => $e,
        ]), $code);
    }

    private function getView($code): string
    {
        if (array_key_exists($code, $this->views)) {
            $view = $this->views[$code];
        } else {
            $view = $this->views['error'];
        }
        return $view;
    }
}
