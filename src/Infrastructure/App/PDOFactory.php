<?php

namespace Infrastructure\App;

use Psr\Container\ContainerInterface;

class PDOFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config')['pdo'];

        return new \PDO(
            $config['dsn'],
            $config['username'],
            $config['password'],
            $config['options']
        );
    }
}
