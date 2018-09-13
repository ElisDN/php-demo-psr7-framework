<?php

return [
    'dependencies' => [
        'factories'  => [
            Doctrine\ORM\EntityManagerInterface::class => ContainerInteropDoctrine\EntityManagerFactory::class,
        ],
    ],

    'doctrine' => [
        'configuration' => [
            'orm_default' => [
                'result_cache' => 'filesystem',
                'metadata_cache' => 'filesystem',
                'query_cache' => 'filesystem',
                'hydration_cache' => 'filesystem',
            ],
        ],
        'connection' => [
            'orm_default' => [
                'driver_class' => \Doctrine\DBAL\Driver\PDOSqlite\Driver::class,
                'pdo' => PDO::class,
            ],
        ],
        'driver' => [
            'orm_default' => [
                'class' => Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain::class,
                'drivers' => [
                    'App\Entity' => 'entities',
                ],
            ],
            'entities' => [
                'class' => Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'filesystem',
                'paths' => ['src/App/Entity'],
            ],
        ],
        'cache' => [
            'filesystem' => [
                'class' => Doctrine\Common\Cache\FilesystemCache::class,
                'directory' => 'var/cache/doctrine',
            ],
        ],
    ],
];
