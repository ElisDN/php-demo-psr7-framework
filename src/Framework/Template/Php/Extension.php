<?php

namespace Framework\Template\Php;

abstract class Extension
{
    /**
     * @return SimpleFunction[]
     */
    public function getFunctions(): array
    {
        return [];
    }
}
