<?php

namespace SylusCode\MultiSport\MysportsWrapper\Api\Options;

class Options
{
    private $filters = [];

    /**
     * @return FilterInterface[]
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    public function addFilter(FilterInterface $filter): self
    {
        array_push($this->filters, $filter);

        return $this;
    }
}