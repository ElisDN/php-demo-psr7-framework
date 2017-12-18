<?php

namespace App\Http\Action\Blog;

use App\ReadModel\PostReadRepository;
use Framework\Template\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Diactoros\Response\HtmlResponse;

class ShowAction implements RequestHandlerInterface
{
    private $posts;
    private $template;

    public function __construct(PostReadRepository $posts, TemplateRenderer $template)
    {
        $this->posts = $posts;
        $this->template = $template;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if (!$post = $this->posts->find($request->getAttribute('id'))) {
            return new EmptyResponse(404);
        }

        return new HtmlResponse($this->template->render('app/blog/show', [
            'post' => $post
        ]));
    }
}
