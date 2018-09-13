<?php

namespace Infrastructure\App\Twig;

use Psr\Container\ContainerInterface;
use Stormiix\Twig\Extension\MixExtension;

class MixExtensionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config')['mix'];

        return new MixExtension(
            $config['root'],
            $config['manifest']
        );
    }
}
