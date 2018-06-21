#!/usr/bin/env php
<?php

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Symfony\Component\Console\Application;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

/**
 * @var \Psr\Container\ContainerInterface $container
 */
$container = require 'config/container.php';

$cli = new Application('Application console');

$entityManager = $container->get(EntityManagerInterface::class);
$cli->getHelperSet()->set(new EntityManagerHelper($entityManager), 'em');

Doctrine\ORM\Tools\Console\ConsoleRunner::addCommands($cli);

$commands = $container->get('config')['console']['commands'];
foreach ($commands as $command) {
    $cli->add($container->get($command));
}

$cli->run();
