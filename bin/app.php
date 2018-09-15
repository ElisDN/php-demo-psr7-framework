#!/usr/bin/env php
<?php

use App\Console\Command\CacheClearCommand;
use Framework\Console\Input;
use Framework\Console\Output;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

/**
 * @var \Psr\Container\ContainerInterface $container
 * @var \Framework\Console\Command[] $commands
 */
$container = require 'config/container.php';

$commands = [
    $container->get(CacheClearCommand::class),
];
$input = new Input($argv);
$output = new Output();
$name = $input->getArgument(0);

if (!empty($name)) {
    foreach ($commands as $command) {
        if ($command->getName() === $name) {
            $command->execute($input, $output);
            exit;
        }
    }
    throw new InvalidArgumentException('Undefined command ' . $name);
}

$output->writeln('<comment>Available commands:</comment>');
$output->writeln('');
foreach ($commands as $command) {
    $output->writeln('<info>' . $command->getName() . '</info>' . "\t" . $command->getDescription());
}
$output->writeln('');