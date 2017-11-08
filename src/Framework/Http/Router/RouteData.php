<?php

namespace Framework\Http\Router;

class RouteData
{
    public $name;
    public $path;
    public $handler;
    public $methods;
    public $options;

    public function __construct($name, $path, $handler, array $methods, array $options)
    {
        $this->name = $name;
        $this->path = $path;
        $this->handler = $handler;
        $this->methods = array_map('mb_strtoupper', $methods);
        $this->options = $options;
    }
}
