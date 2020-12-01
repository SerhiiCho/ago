<?php

declare(strict_types=1);

/**
 * @param int $number The number of seconds, minutes, hours, days, weeks, months and years.
 * @param int $last_digit Last digit of the number, if number with 1 digit return it.
 *
 * @return bool[]
 */
return function (int $number, int $last_digit): array {
    return [
        'single' => $number === 0 || $number === 1,
        'plural' => $number > 1,
    ];
};
