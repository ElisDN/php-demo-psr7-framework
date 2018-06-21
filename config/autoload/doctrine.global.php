<?php

return [
    'dependencies' => [
        'factories'  => [
            Doctrine\ORM\EntityManagerInterface::class => ContainerInteropDoctrine\EntityManagerFactory::class,
            PDO::class => Infrastructure\App\PDOFactory::class,
        ],
    ],

    'doctrine' => [
        'driver' => [
            'orm_default' => [
                'class' => Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain::class,
                'drivers' => [
                    'App\Entity' => 'entities',
                ],
            ],
            'entities' => [
                'class' => Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => ['src/App/Entity'],
            ],
        ],
    ],
];
