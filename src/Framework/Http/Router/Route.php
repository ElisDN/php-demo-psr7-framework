<?php

namespace Framework\Http\Router;

class Route
{
    public $name;
    public $pattern;
    public $handler;
    public $tokens;
    public $methods;

    public function __construct($name, $pattern, $handler, array $methods, array $tokens = [])
    {
        $this->name = $name;
        $this->pattern = $pattern;
        $this->handler = $handler;
        $this->tokens = $tokens;
        $this->methods = $methods;
    }
}
