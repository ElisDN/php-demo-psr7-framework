<?php

namespace Tests\Framework\Container;

use Framework\Container\Container;
use Framework\Container\ServiceNotFoundException;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    public function testPrimitives()
    {
        $container = new Container();

        $container->set($name = 'name', $value = 5);
        self::assertEquals($value, $container->get($name));

        $container->set($name = 'name', $value = 'string');
        self::assertEquals($value, $container->get($name));

        $container->set($name = 'name', $value = ['array']);
        self::assertEquals($value, $container->get($name));

        $container->set($name = 'name', $value = new \stdClass());
        self::assertEquals($value, $container->get($name));
    }

    public function testCallback()
    {
        $container = new Container();

        $container->set($name = 'name', function () {
            return new \stdClass();
        });

        self::assertNotNull($value = $container->get($name));
        self::assertInstanceOf(\stdClass::class, $value);
    }

    public function testContainerPass()
    {
        $container = new Container();

        $container->set('param', $value = 15);
        $container->set($name = 'name', function (Container $container) {
            $object = new \stdClass();
            $object->param = $container->get('param');
            return $object;
        });

        self::assertObjectHasAttribute('param', $object = $container->get($name));
        self::assertEquals($value, $object->param);
    }

    public function testSingleton()
    {
        $container = new Container();

        $container->set($name = 'name', function () {
            return new \stdClass();
        });

        self::assertNotNull($value1 = $container->get($name));
        self::assertNotNull($value2 = $container->get($name));
        self::assertSame($value1, $value2);
    }

    public function testAutoInstantiating()
    {
        $container = new Container();

        self::assertNotNull($value1 = $container->get(\stdClass::class));
        self::assertNotNull($value2 = $container->get(\stdClass::class));

        self::assertInstanceOf(\stdClass::class, $value1);
        self::assertInstanceOf(\stdClass::class, $value2);

        self::assertSame($value1, $value2);
    }

    public function testAutowiring()
    {
        $container = new Container();

        $outer = $container->get(Outer::class);

        self::assertNotNull($outer);
        self::assertInstanceOf(Outer::class, $outer);

        self::assertNotNull($middle = $outer->middle);
        self::assertInstanceOf(Middle::class, $middle);

        self::assertNotNull($inner = $middle->inner);
        self::assertInstanceOf(Inner::class, $inner);
    }

    public function testAutowiringScalarWithDefault()
    {
        $container = new Container();

        $scalar = $container->get(ScalarWithArrayAndDefault::class);

        self::assertNotNull($scalar);

        self::assertNotNull($inner = $scalar->inner);
        self::assertInstanceOf(Inner::class, $inner);

        self::assertEquals([], $scalar->array);
        self::assertEquals(10, $scalar->default);
    }

    public function testAutowiringScalarWithoutDefault()
    {
        $container = new Container();

        $this->expectException(ServiceNotFoundException::class);

        $container->get(ScalarWithOutDefault::class);
    }

    public function testNotFound()
    {
        $container = new Container();

        $this->expectException(ServiceNotFoundException::class);

        $container->get('email');
    }
}

class Outer
{
    public $middle;

    public function __construct(Middle $middle)
    {
        $this->middle = $middle;
    }
}

class Middle
{
    public $inner;

    public function __construct(Inner $inner)
    {
        $this->inner = $inner;
    }
}

class Inner
{

}

class ScalarWithArrayAndDefault
{
    public $inner;
    public $array;
    public $default;

    public function __construct(Inner $inner, array $array, $default = 10)
    {
        $this->inner = $inner;
        $this->array = $array;
        $this->default = $default;
    }
}

class ScalarWithOutDefault
{
    public $inner;
    public $some;

    public function __construct(Inner $inner, $some)
    {
        $this->inner = $inner;
        $this->some = $some;
    }
}


