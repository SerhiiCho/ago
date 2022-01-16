<?php

declare(strict_types=1);

namespace Serhii\Ago;

use DateTimeInterface;
use Serhii\Ago\Exceptions\WrongDateFormatException;

class DateConverter
{
    /**
     * Converts given date into a timestamp
     *
     * @param string|int|\DateTime|\DateTimeImmutable $date
     *
     * @return int
     * @throws \Serhii\Ago\Exceptions\WrongDateFormatException
     */
    public static function convertDateIntoTimestamp($date): int
    {
        if (\is_string($date)) {
            $result = \strtotime($date);

            if ($result === false) {
                throw new WrongDateFormatException("Cannot convert string $date to a timestamp");
            }

            return $result;
        }

        if ($date instanceof DateTimeInterface) {
            return $date->getTimestamp();
        }

        return $date;
    }
}