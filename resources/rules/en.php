<?php

declare(strict_types=1);

/**
 * @param int $number The number that represents seconds, minutes, hours, days, weeks, months and years.
 * If input is 1 year, this number will be 1, if input is 5 minutes this number will be 5.
 * @param int $last_digit Last digit of the number. For example 23 will be 3, 2 will be 2, 60 will be 0.
 *
 * @return bool[]|array[]
 */
return static function (int $number, int $last_digit): array {
    return [
        'single' => $number === 1,
        'plural' => $number > 1 || $number === 0,
    ];
};
