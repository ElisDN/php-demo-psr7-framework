#!/usr/bin/env php
<?php

use App\Console\Command\CacheClearCommand;
use Framework\Console\Input;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

/**
 * @var \Psr\Container\ContainerInterface $container
 */
$container = require 'config/container.php';

$command = $container->get(CacheClearCommand::class);

$input = new Input($argv);

$command->execute($input);