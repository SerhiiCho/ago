<?php

declare(strict_types=1);

return [

    'single' => [
        function (int $number, int $last_number): bool {
            return $last_number === 1;
        },
    ],
    'plural' => [
        function (int $number, int $last_number): bool {
            return $last_number > 1 && $last_number < 5;
        },
    ],
    'special' => [
        function (int $number, int $last_number): bool {
            return $number >= 5 && $number <= 20;
        },
        function (int $num, int $last_number): bool {
            return $last_number >= 6 && $last_number <= 9;
        },
    ],

];
