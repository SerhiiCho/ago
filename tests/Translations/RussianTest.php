<?php

declare(strict_types=1);

namespace Serhii\Tests\Translations;

use Carbon\CarbonImmutable;
use PHPUnit\Framework\TestCase;
use Serhii\Ago\Lang;
use Serhii\Ago\TimeAgo;
use Exception;

class RussianTest extends TestCase
{
    private $language = 'ru';

    /**
     * @dataProvider providerForReturnsCorrectTimeFromOneMinuteAndAbove
     *
     *
     * @param string $method
     * @param int $time
     * @param string $output_expected
     *
     * @throws \Serhii\Ago\Exceptions\MissingRuleException
     */
    public function testReturnsCorrectTimeFromOneMinuteAndAbove(string $method, int $time, string $output_expected): void
    {
        Lang::set($this->language);
        $date = CarbonImmutable::now()->{$method}($time)->toDateTimeString();
        $this->assertSame($output_expected, TimeAgo::trans($date));
    }

    public function providerForReturnsCorrectTimeFromOneMinuteAndAbove(): array
    {
        return [
            ['subSeconds', 60, '1 минута назад'],
            ['subMinutes', 1, '1 минута назад'],
            ['subMinutes', 2, '2 минуты назад'],
            ['subMinutes', 3, '3 минуты назад'],
            ['subMinutes', 4, '4 минуты назад'],
            ['subMinutes', 5, '5 минут назад'],
            ['subMinutes', 6, '6 минут назад'],
            ['subMinutes', 7, '7 минут назад'],
            ['subMinutes', 8, '8 минут назад'],
            ['subMinutes', 9, '9 минут назад'],
            ['subMinutes', 10, '10 минут назад'],
            ['subMinutes', 11, '11 минут назад'],
            ['subMinutes', 12, '12 минут назад'],
            ['subMinutes', 13, '13 минут назад'],
            ['subMinutes', 14, '14 минут назад'],
            ['subMinutes', 15, '15 минут назад'],
            ['subMinutes', 16, '16 минут назад'],
            ['subMinutes', 21, '21 минута назад'],
            ['subMinutes', 22, '22 минуты назад'],
            ['subMinutes', 23, '23 минуты назад'],
            ['subMinutes', 24, '24 минуты назад'],
            ['subMinutes', 25, '25 минут назад'],
            ['subMinutes', 59, '59 минут назад'],
            ['subMinutes', 59, '59 минут назад'],
            ['subMinutes', 60, '1 час назад'],
            ['subHours', 1, '1 час назад'],
            ['subHours', 2, '2 часа назад'],
            ['subHours', 3, '3 часа назад'],
            ['subHours', 4, '4 часа назад'],
            ['subHours', 5, '5 часов назад'],
            ['subHours', 6, '6 часов назад'],
            ['subHours', 7, '7 часов назад'],
            ['subHours', 8, '8 часов назад'],
            ['subHours', 9, '9 часов назад'],
            ['subHours', 10, '10 часов назад'],
            ['subHours', 11, '11 часов назад'],
            ['subHours', 12, '12 часов назад'],
            ['subHours', 13, '13 часов назад'],
            ['subHours', 14, '14 часов назад'],
            ['subHours', 15, '15 часов назад'],
            ['subHours', 16, '16 часов назад'],
            ['subHours', 17, '17 часов назад'],
            ['subHours', 18, '18 часов назад'],
            ['subHours', 19, '19 часов назад'],
            ['subHours', 20, '20 часов назад'],
            ['subHours', 21, '21 час назад'],
            ['subHours', 22, '22 часа назад'],
            ['subHours', 23, '23 часа назад'],
            ['subHours', 24, '1 день назад'],
            ['subDays', 2, '2 дня назад'],
            ['subDays', 7, '1 неделя назад'],
            ['subWeeks', 2, '2 недели назад'],
            ['subMonths', 1, '1 месяц назад'],
            ['subMonths', 2, '2 месяца назад'],
            ['subMonths', 11, '11 месяцев назад'],
            ['subMonths', 12, '1 год назад'],
            ['subYears', 2, '2 года назад'],
            ['subYears', 5, '5 лет назад'],
            ['subYears', 8, '8 лет назад'],
            ['subYears', 21, '21 год назад'],
            ['subYears', 22, '22 года назад'],
            ['subYears', 30, '30 лет назад'],
            ['subYears', 31, '31 год назад'],
            ['subYears', 41, '41 год назад'],
            ['subYears', 100, '100 лет назад'],
            ['subYears', 101, '101 год назад'],
        ];
    }

    /**
     * @dataProvider providerForReturnsCorrectDateFrom0SecondsTo59Seconds
     *
     *
     * @param int $seconds
     * @param array $expect
     *
     * @throws Exception
     */
    public function testReturnsCorrectDateFrom0SecondsTo59Seconds(int $seconds, array $expect): void
    {
        Lang::set($this->language);

        $date = CarbonImmutable::now()->subSeconds($seconds)->toDateTimeString();
        $message = sprintf("Expected '%s' or '%s' but got '%s'", $expect[0], $expect[1], $res = TimeAgo::trans($date));
        $this->assertContains($res, $expect, $message);
    }

    public function providerForReturnsCorrectDateFrom0SecondsTo59Seconds(): array
    {
        return [
            [0, ['0 секунд назад', '1 секунда назад']],
            [1, ['1 секунда назад', '2 секунды назад']],
            [2, ['2 секунды назад', '3 секунды назад']],
            [5, ['5 секунд назад', '6 секунд назад']],
            [21, ['21 секунда назад', '22 секунды назад']],
            [58, ['58 секунд назад', '59 секунд назад']],
            [59, ['59 секунд назад', '1 минута назад']],
        ];
    }
}
