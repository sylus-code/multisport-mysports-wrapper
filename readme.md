# MySports Api Wrapper

#### Description
As tomtom has problem with supporting its running watches, I've decided to create a tool to manage trainings  based on Tomtom MySports App


#### Quick start

```php
use GuzzleHttp\Client;
use SylusCode\MultiSport\MysportsWrapper\Api\ApiWrapper;
use SylusCode\MultiSport\MysportsWrapper\Api\CookieAuthenticator;
use SylusCode\MultiSport\MysportsWrapper\Workout\WorkoutParser;
use SylusCode\MultiSport\MysportsWrapper\Workout\WorkoutTypeResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

        $client = new Client();
        $workoutParser = new WorkoutParser();
        
        // you can overwrite type resolver if you need more logic there
        $workoutTypeResolver = new WorkoutTypeResolver();
        $auth = new CookieAuthenticator($client, '******@gmail.com', 'VeryStrongPassw0rd');
        
        $api = new ApiWrapper($client, $auth, $workoutParser, $workoutTypeResolver);
        $result = $api->getWorkouts($options);
        
        var_dump($result);
        
        // Example output:
        array(1) {
          [0]=>
          object(SylusCode\MultiSport\Workout\Workout)#1503 (14) {
            ["time":"SylusCode\MultiSport\Workout\Workout":private]=>
            NULL
            ["type":"SylusCode\MultiSport\Workout\Workout":private]=>
            object(SylusCode\MultiSport\Workout\Type)#1457 (2) {
              ["id":"SylusCode\MultiSport\Workout\Type":private]=>
              int(1)
              ["name":"SylusCode\MultiSport\Workout\Type":private]=>
              string(8) "Bieganie"
            }
            ["distance":"SylusCode\MultiSport\Workout\Workout":private]=>
            float(595.98)
            ["calories":"SylusCode\MultiSport\Workout\Workout":private]=>
            int(36)
            ["durationTotal":"SylusCode\MultiSport\Workout\Workout":private]=>
            int(420)
            ["points":"SylusCode\MultiSport\Workout\Workout":private]=>
            array(18) {
              [0]=>
              object(SylusCode\MultiSport\Workout\Point)#1501 (7) {
                ["time":"SylusCode\MultiSport\Workout\Point":private]=>
                object(DateTime)#1510 (3) {
                  ["date"]=>
                  string(26) "2020-11-12 07:28:17.000000"
                  ["timezone_type"]=>
                  int(2)
                  ["timezone"]=>
                  string(1) "Z"
                }
                ["latitude":"SylusCode\MultiSport\Workout\Point":private]=>
                float(51.392342)
                ["longtitude":"SylusCode\MultiSport\Workout\Point":private]=>
                float(16.696368)
                ["altitude":"SylusCode\MultiSport\Workout\Point":private]=>
                float(113.8)
                ["distance":"SylusCode\MultiSport\Workout\Point":private]=>
                float(0)
                ["heartRate":"SylusCode\MultiSport\Workout\Point":private]=>
                int(108)
                ["speed":"SylusCode\MultiSport\Workout\Point":private]=>
                float(0)
              }
              ..
        
        
```

#### Advanced used

There is an option to use specific filter to select workouts from desired date range by use `ByDateFilter`
You can aloso create your own filters. To do that you need to implement Filter interface.

```
use SylusCode\MultiSport\MysportsWrapper\Api\Options\ByDateFilter;
use SylusCode\MultiSport\MysportsWrapper\Api\Options\Options;

 ..
 $options = new Options();
 $filterDateFrom = ByDateFilter::createWithDateFrom(new \DateTime('2020-09-26'));
 $options->addFilter($filterDateFrom);
 $result = $api->getWorkouts($options);

 
```

#### What's next

Add new filters in example: WorkoutType, Distance, AvgSpeed
Add to Options page number with limit
