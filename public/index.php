<?php

$name = $_GET['name'] ?? 'Guest';

header('X-Developer: ElisDN');
echo 'Hello, ' . $name . '!';