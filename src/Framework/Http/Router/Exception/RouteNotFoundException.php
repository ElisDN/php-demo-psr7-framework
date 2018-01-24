<?php

namespace Framework\Http\Router\Exception;

/**
 * Class RouteNotFoundException
 *
 * @package Framework\Http\Router\Exception
 */
class RouteNotFoundException extends \LogicException
{
    private $name;
    private $params;

    /**
     * RouteNotFoundException constructor.
     *
     * @param                 $name
     * @param array           $params
     * @param \Throwable|null $previous
     */
    public function __construct($name, array $params, \Throwable $previous = null)
    {
        parent::__construct('Route "' . $name . '" not found.', $previous);
        $this->name = $name;
        $this->params = $params;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}
