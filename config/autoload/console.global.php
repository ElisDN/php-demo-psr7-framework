<?php

use App\Console\Command;

return [
    'dependencies' => [
        'factories' => [
            Command\CacheClearCommand::class => Infrastructure\App\Console\Command\CacheClearCommandFactory::class,
        ],
    ],
    'console' => [
        'cachePaths' => [
            'twig' => 'var/cache/twig',
        ],
    ],
];
