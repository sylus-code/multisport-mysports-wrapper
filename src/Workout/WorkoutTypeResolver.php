<?php

namespace SylusCode\MultiSport\MysportsWrapper\Workout;

use SylusCode\MultiSport\MysportsWrapper\MySports\WorkoutDictionary;
use SylusCode\MultiSport\Workout\Type;

class WorkoutTypeResolver implements WorkoutTypeResolverInterface
{
    public function resolve(int $mySportsActivityTypeId): Type
    {
        switch ($mySportsActivityTypeId) {
            case WorkoutDictionary::TYPE_RUN:
                $typeId = Type::TYPE_RUNNING;
                break;
            case WorkoutDictionary::TYPE_INDOOR_RUN:
                $typeId = Type::TYPE_INDOOR_RUN;
                break;
            case WorkoutDictionary::TYPE_BIKE:
                $typeId = Type::TYPE_BIKE;
                break;
            case WorkoutDictionary::TYPE_INDOOR_BIKE:
                $typeId = Type::TYPE_INDOOR_BIKE;
                break;
            case WorkoutDictionary::TYPE_GYM:
                $typeId = Type::TYPE_GYM;
                break;
            case WorkoutDictionary::TYPE_SWIM:
                $typeId = Type::TYPE_SWIMMING;
                break;
            case WorkoutDictionary::TYPE_FREESTYLE:
                $typeId = Type::TYPE_FREESTYLE;
                break;
            default:
                $typeId = Type::TYPE_OTHER;
                break;
        }
        return Type::createFromTypeId($typeId);
    }
}