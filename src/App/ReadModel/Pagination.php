<?php

namespace App\ReadModel;

class Pagination
{
    private $totalCount;
    private $page;
    private $perPage;

    public function __construct(int $totalCount, int $page, int $perPage)
    {
        $this->totalCount = $totalCount;
        $this->page = $page;
        $this->perPage = $perPage;
    }

    public function getTotalCount(): int
    {
        return $this->totalCount;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getPagesCount(): int
    {
        return ceil($this->totalCount / $this->perPage);
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function getLimit(): int
    {
        return $this->perPage;
    }

    public function getOffset(): int
    {
        return ($this->page - 1) * $this->perPage;
    }
}
