<?php

namespace Framework\Http;

class Request
{
    private $queryParams;
    private $parsedBody;

    public function __construct(array $queryParams = [], $parsedBody = null)
    {
        $this->queryParams = $queryParams;
        $this->parsedBody = $parsedBody;
    }

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    public function getParsedBody()
    {
        return $this->parsedBody;
    }
}
