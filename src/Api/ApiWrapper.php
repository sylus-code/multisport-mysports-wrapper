<?php

namespace SylusCode\MultiSport\MysportsWrapper\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use SylusCode\MultiSport\MysportsWrapper\Api\Options\Options;
use SylusCode\MultiSport\MysportsWrapper\Workout\WorkoutParserInterface;
use SylusCode\MultiSport\MysportsWrapper\Workout\WorkoutTypeResolverInterface;
use SylusCode\MultiSport\Workout\Workout;

class ApiWrapper
{
    const DOMAIN = 'mysports.tomtom.com';
    const ACTIVITIES_LIST_URL = "https://mysports.tomtom.com/service/webapi/v2/activity?format=json";
    const ACTIVITY_URL_PATTERN = "https://mysports.tomtom.com/service/webapi/v2/activity/%s?format=tcx";

    private $guzzleClient;
    private $cookieAuthenticator;
    private $workoutParser;
    private $typeResolver;

    public function __construct(
        Client $guzzleClient,
        CookieAuthenticatorInterface $cookieAuthenticator,
        WorkoutParserInterface $workoutParser,
        WorkoutTypeResolverInterface $typeResolver
    )
    {
        $this->guzzleClient = $guzzleClient;
        $this->cookieAuthenticator = $cookieAuthenticator;
        $this->workoutParser = $workoutParser;
        $this->typeResolver = $typeResolver;
    }

    function getWorkouts(Options $options = null): array
    {
        $authCookie = $this->cookieAuthenticator->getCookie();

        $cookieJar = CookieJar::fromArray(
            [
                $authCookie->getName() => $authCookie->getValue()
            ],
            self::DOMAIN
        );

        $response = $this->guzzleClient->request('GET', self::ACTIVITIES_LIST_URL, [
            'cookies' => $cookieJar
        ]);

        $jsonWorkouts = json_decode((string)$response->getBody())->workouts;

        if ($options != null) {

            foreach ($options->getFilters() as $filter) {
                $jsonWorkouts = $filter->filter($jsonWorkouts);
            }
        }

        $workouts = [];

        foreach ($jsonWorkouts as $jsonWorkout) {

            $tcx = $this->guzzleClient->request('GET', sprintf(self::ACTIVITY_URL_PATTERN, $jsonWorkout->id), [
                'cookies' => $cookieJar
            ]);

            $tcxWorkout = $tcx->getBody()->getContents();

            $workout = $this->workoutParser->parseFromTcx($tcxWorkout);
            $workout = $this->composeWorkout($workout, $jsonWorkout);

            $workouts[] = $workout;
        }

        return $workouts;
    }

    private function composeWorkout(Workout $workout, $jsonWorkout): Workout
    {

        $aggregates = $jsonWorkout->aggregates;

        if (isset($aggregates->heartrate_avg)) {
            $workout->setAvgHeartRate((int)$aggregates->heartrate_avg);
        }
        if (isset($aggregates->moving_time_total)) {
            $workout->setDurationActive((int)$aggregates->moving_time_total);
        }
        if (isset($aggregates->steps_total)) {
            $workout->setSteps((int)$aggregates->steps_total);
        }
        if (isset($aggregates->moving_speed_avg)) {
            $workout->setAvgSpeed((int)$aggregates->moving_speed_avg);
        }
        if (isset($jsonWorkout->activity_type_id)) {
            $workout->setType($this->typeResolver->resolve((int)$jsonWorkout->activity_type_id));
        }
        if (isset($jsonWorkout->start_datetime)){
            $workout->setStart(\DateTime::createFromFormat(DATE_ISO8601, $jsonWorkout->start_datetime));
        }

        return $workout;
    }
}
