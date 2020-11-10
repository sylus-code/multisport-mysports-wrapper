<?php

namespace SylusCode\MultiSport\MysportsWrapper\Workout;

use SylusCode\MultiSport\Workout\Workout;
use SylusCode\MultiSport\Workout\Point;

class WorkoutParser implements WorkoutParserInterface
{
    public function parseFromTcx(string $tcx): Workout
    {
        $training = simplexml_load_string($tcx) or die("Error: Cannot create object");
        $activity = $training->Activities->Activity;

        $workout = new Workout();
        $points = [];

        foreach ($activity->Lap->Track->Trackpoint as $trackPoint) {

            $point = $this->createPoint($trackPoint);
            $points[] = $point;
        }

        $workout->setPoints($points);
        $workout->setDurationTotal((int)$activity->Lap->TotalTimeSeconds);
        $workout->setCalories((int)$activity->Lap->Calories);
        $workout->setDistance((float)$activity->Lap->DistanceMeters);

        return $workout;
    }

    private function createPoint($trackPoint): Point
    {
        $point = new Point();
        $point->setTime(\DateTime::createFromFormat(DATE_ISO8601, $trackPoint->Time));
        if (isset($trackPoint->Position)) {
            $point->setLatitude((float)$trackPoint->Position->LatitudeDegrees);
            $point->setLongtitude((float)$trackPoint->Position->LongitudeDegrees);
        }
        if (isset($trackPoint->AltitudeMeters)) {
            $point->setAltitude((float)$trackPoint->AltitudeMeters);
        }
        if (isset($trackPoint->DistanceMeters)) {
            $point->setDistance((float)$trackPoint->DistanceMeters);
        }
        if (isset($trackPoint->HeartRateBpm)) {
            $point->setHeartRate((int)$trackPoint->HeartRateBpm->Value);
        }
        if (isset($trackPoint->Extensions)) {
            $point->setSpeed((float)$trackPoint->Extensions->xpath('x:TPX')[0]->Speed);
        }

        return $point;
    }
}