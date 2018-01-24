<?php

namespace App\Http\Action\Blog;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class ShowAction
{
    /**
     * @param ServerRequestInterface $request
     * @param callable               $next
     *
     * @return JsonResponse
     * @throws \InvalidArgumentException
     */
    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        $id = $request->getAttribute('id');

        if ($id > 2) {
            return $next($request);
        }

        return new JsonResponse(['id' => $id, 'title' => 'Post #' . $id]);
    }
}
