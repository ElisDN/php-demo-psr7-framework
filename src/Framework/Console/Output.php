<?php

namespace Framework\Console;

class Output
{
    public function write(string $message): void
    {
        echo $message;
    }

    public function writeln(string $message): void
    {
        echo $message . PHP_EOL;
    }

    public function comment($message): void
    {
        $this->writeln("\033[33m" . $message . "\033[0m");
    }

    public function info($message): void
    {
        $this->writeln("\033[32m" . $message . "\033[0m");
    }
}