<?php

namespace SylusCode\MultiSport\MysportsWrapper\Api\Options;

class QuantityFilter implements FilterInterface
{
    private $quantity;

    public function __construct(int $quantity)
    {
        $this->quantity = $quantity;
    }

    public function filter($jsonWorkouts): array
    {
        $quantity = $this->quantity;

        return array_slice($jsonWorkouts, 0, $quantity);
    }
}