<?php

declare(strict_types=1);

return [

    'second' => [
        function (int $num, int $last_num): bool {
            return $num === 1;
        },
    ],
    'seconds' => [
        function (int $num, int $last_num): bool {
            return $num > 1;
        },
    ],
    'seconds2' => 'seconds',
    'minute' => 'second',
    'minutes' => 'seconds',
    'minutes2' => 'seconds',
    'hour' => 'second',
    'hours' => 'seconds',
    'hours2' => 'seconds',
    'day' => 'second',
    'days' => 'seconds',
    'days2' => 'seconds',
    'week' => 'second',
    'weeks' => 'seconds',
    'weeks2' => 'seconds',
    'month' => 'second',
    'months' => 'seconds',
    'months2' => 'seconds',
    'year' => 'second',
    'years' => 'seconds',
    'years2' => 'seconds',

];
