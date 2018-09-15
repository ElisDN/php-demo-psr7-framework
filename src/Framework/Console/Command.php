<?php

declare(strict_types=1);

namespace Framework\Console;

interface Command
{
    public function execute(Input $input, Output $output): void;
}