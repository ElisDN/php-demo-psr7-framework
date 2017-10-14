<?php

$configs = array_map(
    function ($file) {
        return require $file;
    },
    glob(__DIR__ . '/autoload/{{,*.}global,{,*.}local}.php', GLOB_BRACE)
);

return array_merge_recursive(...$configs);
