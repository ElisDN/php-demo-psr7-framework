<?php

namespace Framework\Http;

class Request
{
    private $queryParams = [];
    private $parsedBody;

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    public function withQueryParams(array $query)
    {
        $this->queryParams = $query;
    }

    public function getParsedBody()
    {
        return $this->parsedBody;
    }

    public function withParsedBody($data)
    {
        $this->parsedBody = $data;
    }
}
