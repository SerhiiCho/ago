<?php

declare(strict_types=1);

return [

    'single' => [
        function (int $number, int $last_number): bool {
            return $number === 1;
        },
    ],
    'plural' => [
        function (int $number, int $last_number): bool {
            return $number > 1;
        },
    ],

];
