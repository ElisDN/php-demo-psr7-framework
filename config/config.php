<?php

return array_merge_recursive(
    require __DIR__ . '/autoload/app.global.php',
    require __DIR__ . '/autoload/auth.global.php',
    require __DIR__ . '/autoload/app.local.php',
    require __DIR__ . '/autoload/auth.local.php',
    require __DIR__ . '/autoload/local.php'
);