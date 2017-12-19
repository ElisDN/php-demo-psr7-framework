<?php

use Zend\ServiceManager\ServiceManager;

$config = require __DIR__ . '/config.php';

$container = new ServiceManager($config['dependencies']);

$container->setService('config', $config);

return $container;
