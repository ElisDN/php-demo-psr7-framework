<?php

namespace Framework\Http;

interface ServerRequestInterface
{
    public function getQueryParams(): array;

    /**
     * @param array $query
     * @return static
     */
    public function withQueryParams(array $query);

    public function getParsedBody();

    /**
     * @param $data
     * @return static
     */
    public function withParsedBody($data);
}