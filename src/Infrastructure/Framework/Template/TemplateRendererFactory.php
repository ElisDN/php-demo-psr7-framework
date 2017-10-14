<?php

namespace Infrastructure\Framework\Template;

use Framework\Template\Twig\TwigRenderer;
use Psr\Container\ContainerInterface;
use Twig\Environment;

class TemplateRendererFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new TwigRenderer(
            $container->get(Environment::class),
            $container->get('config')['templates']['extension']
        );
    }
}
