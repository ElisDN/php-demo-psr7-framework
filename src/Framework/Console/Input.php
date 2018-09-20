<?php

namespace Framework\Console;

class Input
{
    private $args;

    public function __construct(array $argv)
    {
        $this->args = \array_slice($argv, 1);
    }

    public function getArgument(int $index): string
    {
        return $this->args[$index] ?? '';
    }

    public function read(): string
    {
        return fgets(\STDIN);
    }
}
