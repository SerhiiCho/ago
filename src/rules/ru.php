<?php

declare(strict_types=1);

return [

    'single' => [
        function (int $num, int $last_num): bool {
            return $last_num === 1;
        },
    ],
    'plural' => [
        function (int $num, int $last_num): bool {
            return $last_num > 1 && $last_num < 5;
        },
    ],
    'special' => [
        function (int $num, int $last_num): bool {
            return $num >= 5 && $num <= 20;
        },
        function (int $num, int $last_num): bool {
            return $last_num >= 6 && $last_num <= 9;
        },
    ],

];
