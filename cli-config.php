<?php

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Symfony\Component\Console\Helper\DebugFormatterHelper;
use Symfony\Component\Console\Helper\FormatterHelper;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\ProcessHelper;
use Symfony\Component\Console\Helper\QuestionHelper;

require 'vendor/autoload.php';

/**
 * @var \Psr\Container\ContainerInterface $container
 */
$container = require 'config/container.php';

return new HelperSet([
    new FormatterHelper(),
    new DebugFormatterHelper(),
    new ProcessHelper(),
    new QuestionHelper(),
    'em' => new EntityManagerHelper($container->get(EntityManagerInterface::class)),
]);