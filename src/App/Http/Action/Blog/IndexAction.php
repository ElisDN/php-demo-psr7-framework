<?php

namespace App\Http\Action\Blog;

use App\ReadModel\Pagination;
use App\ReadModel\PostReadRepository;
use Framework\Template\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;

class IndexAction implements RequestHandlerInterface
{
    private const PER_PAGE = 5;

    private $posts;
    private $template;

    public function __construct(PostReadRepository $posts, TemplateRenderer $template)
    {
        $this->posts = $posts;
        $this->template = $template;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $pager = new Pagination(
            $this->posts->countAll(),
            $request->getAttribute('page') ?: 1,
            self::PER_PAGE
        );

        $posts = $this->posts->getAll(
            $pager->getOffset(),
            $pager->getLimit()
        );

        return new HtmlResponse($this->template->render('app/blog/index', [
            'posts' => $posts,
            'pager' => $pager,
        ]));
    }
}
