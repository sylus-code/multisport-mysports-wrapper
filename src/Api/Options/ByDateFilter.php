<?php

namespace SylusCode\MultiSport\MysportsWrapper\Api\Options;

class ByDateFilter implements FilterInterface
{
    private $dateFrom;
    private $dateTo;

    public function __construct(\DateTime $dateFrom = null, \DateTime $dateTo = null)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    public function filter($jsonWorkouts): array
    {
        $dateFrom = $this->dateFrom;
        $dateTo = $this->dateTo;

        return array_filter($jsonWorkouts, function ($jsonWorkout) use ($dateFrom, $dateTo) {
            $startTime = \DateTime::createFromFormat(DATE_ISO8601, $jsonWorkout->start_datetime);
            if ($dateFrom && $dateTo) {
                return $startTime > $dateFrom && $startTime < $dateTo;
            } elseif ($dateFrom) {
                return $startTime > $dateFrom;
            } elseif ($dateTo) {
                return $startTime < $dateTo;
            } else {
                return true;
            }
        });
    }

    public static function createWithDateFrom(\DateTime $dateFrom): self
    {
        return new self($dateFrom);
    }

    public static function createWithDateTo(\DateTime $dateTo): self
    {
        return new self(null, $dateTo);
    }

    public static function createWithDateRange(\DateTime $dateFrom, \DateTime $dateTo): self
    {
        return new self($dateFrom, $dateTo);
    }
}