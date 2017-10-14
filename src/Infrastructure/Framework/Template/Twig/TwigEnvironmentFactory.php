<?php

namespace Infrastructure\Framework\Template\Twig;

use Framework\Template\Twig\Extension\RouteExtension;
use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

class TwigEnvironmentFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $debug = $container->get('config')['debug'];
        $config = $container->get('config')['twig'];

        $loader = new FilesystemLoader();
        $loader->addPath($config['template_dir']);

        $environment = new Environment($loader, [
            'cache' => $debug ? false : $config['cache_dir'],
            'debug' => $debug,
            'strict_variables' => $debug,
            'auto_reload' => $debug,
        ]);

        if ($debug) {
            $environment->addExtension(new DebugExtension());
        }

        $environment->addExtension($container->get(RouteExtension::class));

        foreach ($config['extensions'] as $extension) {
            $environment->addExtension($container->get($extension));
        }

        return $environment;
    }
}
