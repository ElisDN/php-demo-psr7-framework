<?php

namespace App\Http\Action\Blog;

use App\ReadModel\PostReadRepository;
use Framework\Template\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;

class ShowAction implements MiddlewareInterface
{
    private $posts;
    private $template;

    public function __construct(PostReadRepository $posts, TemplateRenderer $template)
    {
        $this->posts = $posts;
        $this->template = $template;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!$post = $this->posts->find($request->getAttribute('id'))) {
            return $handler->handle($request);
        }

        return new HtmlResponse($this->template->render('app/blog/show', [
            'post' => $post
        ]));
    }
}
