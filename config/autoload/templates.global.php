<?php

use Framework\Template\TemplateRenderer;

return [
    'dependencies' => [
        'factories' => [
            TemplateRenderer::class => Infrastructure\Framework\Template\TemplateRendererFactory::class,
            Twig\Environment::class => Infrastructure\Framework\Template\Twig\TwigEnvironmentFactory::class,
            Stormiix\Twig\Extension\MixExtension::class => Infrastructure\App\Twig\MixExtensionFactory::class,
        ],
    ],

    'templates' => [
        'extension' => '.html.twig',
    ],

    'twig' => [
        'template_dir' => 'templates',
        'cache_dir' => 'var/cache/twig',
        'extensions' => [
            Stormiix\Twig\Extension\MixExtension::class,
        ],
    ],

    'mix' => [
        'root' => 'public/build',
        'manifest' => 'mix-manifest.json',
    ],
];
