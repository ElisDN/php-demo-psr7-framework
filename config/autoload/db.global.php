<?php

return [
    'dependencies' => [
        'factories' => [
            PDO::class => Infrastructure\App\PDOFactory::class,
        ]
    ],

    'pdo' => [
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ],
    ],
];
