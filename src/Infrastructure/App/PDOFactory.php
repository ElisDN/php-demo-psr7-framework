<?php

namespace Infrastructure\App;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

class PDOFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /** @var EntityManagerInterface $em */
        $em = $container->get(EntityManagerInterface::class);

        return $em->getConnection()->getWrappedConnection();
    }
}
