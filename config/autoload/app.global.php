<?php

use App\Http\Middleware;
use Framework\Http\Application;
use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Router\Router;
use Framework\Template\TemplateRenderer;
use Framework\Template\Twig\TwigRenderer;
use Psr\Container\ContainerInterface;

return [
    'dependencies' => [
        'abstract_factories' => [
            Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory::class,
        ],
        'factories' => [
            Application::class => function (ContainerInterface $container) {
                return new Application(
                    $container->get(MiddlewareResolver::class),
                    $container->get(Router::class),
                    $container->get(Middleware\NotFoundHandler::class),
                    new Zend\Diactoros\Response()
                );
            },
            Router::class => function () {
                return new AuraRouterAdapter(new Aura\Router\RouterContainer());
            },
            MiddlewareResolver::class => function (ContainerInterface $container) {
                return new MiddlewareResolver($container);
            },
            Middleware\ErrorHandlerMiddleware::class => function (ContainerInterface $container) {
                return new Middleware\ErrorHandlerMiddleware(
                    $container->get('config')['debug'],
                    $container->get(TemplateRenderer::class)
                );
            },
            TemplateRenderer::class => function (ContainerInterface $container) {
                return new TwigRenderer($container->get(Twig\Environment::class), '.html.twig');
            },
            Twig\Environment::class => function(ContainerInterface $container)
            {
                $templateDir = 'templates';
                $cacheDir = 'var/cache/twig';
                $debug = $container->get('config')['debug'];

                $loader = new Twig\Loader\FilesystemLoader();
                $loader->addPath($templateDir);

                $environment = new Twig\Environment($loader, [
                    'cache' => $debug ? false : $cacheDir,
                    'debug' => $debug,
                    'strict_variables' => $debug,
                    'auto_reload' => $debug,
                ]);

                if ($debug) {
                    $environment->addExtension(new Twig\Extension\DebugExtension());
                }

                return $environment;
            },
        ],
    ],

    'debug' => false,
];
