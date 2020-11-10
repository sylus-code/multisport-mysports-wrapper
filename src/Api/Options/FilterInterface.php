<?php

namespace SylusCode\MultiSport\MysportsWrapper\Api\Options;

interface FilterInterface
{
    public function filter($jsonWorkouts): array;
}