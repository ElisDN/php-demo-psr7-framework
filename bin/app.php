#!/usr/bin/env php
<?php

use App\Console\Command\CacheClearCommand;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

/**
 * @var \Psr\Container\ContainerInterface $container
 */
$container = require 'config/container.php';

$command = $container->get(CacheClearCommand::class);

$args = array_slice($argv, 1);

$command->execute($args);