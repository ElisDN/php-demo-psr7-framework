<?php

use Framework\Http\Request;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

### Initialization

$request = (new Request())
    ->withQueryParams($_GET)
    ->withParsedBody($_POST);

### Action

$name = $request->getQueryParams()['name'] ?? 'Guest';
header('X-Developer: ElisDN');
echo 'Hello, ' . $name . '!';