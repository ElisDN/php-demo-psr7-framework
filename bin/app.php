#!/usr/bin/env php
<?php

use App\Console\Command\CacheClearCommand;
use Framework\Console\Application;
use Framework\Console\Input;
use Framework\Console\Output;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

/**
 * @var \Psr\Container\ContainerInterface $container
 */
$container = require 'config/container.php';

$cli = new Application();
$cli->add($container->get(CacheClearCommand::class));
$cli->run(new Input($argv), new Output());
