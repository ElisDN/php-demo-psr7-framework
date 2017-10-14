<?php

namespace Tests\Framework\Http;

use Framework\Container\Container;
use Framework\Container\ServiceNotFoundException;

class DummyContainer extends Container
{
    public function get($id)
    {
        if (!class_exists($id)) {
            throw new ServiceNotFoundException($id);
        }
        return new $id();
    }

    public function has($id): bool
    {
        return class_exists($id);
    }
}
