<?php

namespace SylusCode\MultiSport\MysportsWrapper\Workout;

use SylusCode\MultiSport\Workout\Workout;

interface WorkoutParserInterface
{
    public function parseFromTcx(string $tcx): Workout;
}