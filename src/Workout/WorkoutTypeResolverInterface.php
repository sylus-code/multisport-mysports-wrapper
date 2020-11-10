<?php

namespace SylusCode\MultiSport\MysportsWrapper\Workout;

use SylusCode\MultiSport\Workout\Type;

interface WorkoutTypeResolverInterface
{
    public function resolve(int $mySportsActivityTypeId): Type;
}
