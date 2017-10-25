<?php

use Framework\Template\TemplateRenderer;
use Framework\Template\Twig\Extension\RouteExtension;
use Framework\Template\Twig\TwigRenderer;
use Psr\Container\ContainerInterface;

return [
    'dependencies' => [
        'factories' => [
            TemplateRenderer::class => function (ContainerInterface $container) {
                return new TwigRenderer(
                    $container->get(Twig\Environment::class),
                    $container->get('config')['templates']['extension']
                );
            },
            Twig\Environment::class => function(ContainerInterface $container)
            {
                $debug = $container->get('config')['debug'];
                $config = $container->get('config')['twig'];

                $loader = new Twig\Loader\FilesystemLoader();
                $loader->addPath($config['template_dir']);

                $environment = new Twig\Environment($loader, [
                    'cache' => $debug ? false : $config['cache_dir'],
                    'debug' => $debug,
                    'strict_variables' => $debug,
                    'auto_reload' => $debug,
                ]);

                if ($debug) {
                    $environment->addExtension(new Twig\Extension\DebugExtension());
                }

                $environment->addExtension($container->get(RouteExtension::class));

                foreach ($config['extensions'] as $extension) {
                    $environment->addExtension($container->get($extension));
                }

                return $environment;
            },
        ],
    ],

    'templates' => [
        'extension' => '.html.twig',
    ],

    'twig' => [
        'template_dir' => 'templates',
        'cache_dir' => 'var/cache/twig',
        'extensions' => [],
    ],
];
