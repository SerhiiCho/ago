<?php

declare(strict_types=1);

namespace Serhii\Tests;

use Carbon\CarbonImmutable;
use Serhii\Ago\Time;
use PHPUnit\Framework\TestCase;
use Serhii\Ago\Lang;

class TimeTest extends TestCase
{
    /**
     * @dataProvider Provider_for_returns_correct_time
     * @test
     * @param string $method
     * @param int $time
     * @param string $output_expected
     * @param string $lang
     */
    public function returns_correct_time(string $method, int $time, string $output_expected, string $lang): void
    {
        Lang::set($lang);
        $date = CarbonImmutable::now()->{$method}($time)->toDateTimeString();
        $this->assertSame($output_expected, Time::ago($date));
    }

    public function Provider_for_returns_correct_time(): array
    {
        return [
            // english
            ['subSeconds', 60, '1 minute ago', 'en'],
            ['subMinutes', 1, '1 minute ago', 'en'],
            ['subMinutes', 2, '2 minutes ago', 'en'],
            ['subMinutes', 3, '3 minutes ago', 'en'],
            ['subMinutes', 4, '4 minutes ago', 'en'],
            ['subMinutes', 5, '5 minutes ago', 'en'],
            ['subMinutes', 11, '11 minutes ago', 'en'],
            ['subMinutes', 59, '59 minutes ago', 'en'],
            ['subMinutes', 60, '1 hour ago', 'en'],
            ['subHours', 1, '1 hour ago', 'en'],
            ['subHours', 4, '4 hours ago', 'en'],
            ['subHours', 13, '13 hours ago', 'en'],
            ['subHours', 24, '1 day ago', 'en'],
            ['subDays', 2, '2 days ago', 'en'],
            ['subDays', 7, '1 week ago', 'en'],
            ['subWeeks', 2, '2 weeks ago', 'en'],
            ['subMonths', 1, '1 month ago', 'en'],
            ['subMonths', 2, '2 months ago', 'en'],
            ['subMonths', 11, '11 months ago', 'en'],
            ['subMonths', 12, '1 year ago', 'en'],
            ['subYears', 5, '5 years ago', 'en'],
            ['subYears', 21, '21 years ago', 'en'],
            ['subYears', 31, '31 years ago', 'en'],
            ['subYears', 41, '41 years ago', 'en'],
            ['subYears', 100, '100 years ago', 'en'],
            ['subYears', 101, '101 years ago', 'en'],
            // russian
            ['subSeconds', 60, '1 минута назад', 'ru'],
            ['subMinutes', 1, '1 минута назад', 'ru'],
            ['subMinutes', 2, '2 минуты назад', 'ru'],
            ['subMinutes', 3, '3 минуты назад', 'ru'],
            ['subMinutes', 4, '4 минуты назад', 'ru'],
            ['subMinutes', 5, '5 минут назад', 'ru'],
            ['subMinutes', 6, '6 минут назад', 'ru'],
            ['subMinutes', 7, '7 минут назад', 'ru'],
            ['subMinutes', 8, '8 минут назад', 'ru'],
            ['subMinutes', 9, '9 минут назад', 'ru'],
            ['subMinutes', 10, '10 минут назад', 'ru'],
            ['subMinutes', 11, '11 минут назад', 'ru'],
            ['subMinutes', 12, '12 минут назад', 'ru'],
            ['subMinutes', 13, '13 минут назад', 'ru'],
            ['subMinutes', 59, '59 минут назад', 'ru'],
            ['subMinutes', 60, '1 час назад', 'ru'],
            ['subHours', 1, '1 час назад', 'ru'],
            ['subHours', 2, '2 часа назад', 'ru'],
            ['subHours', 3, '3 часа назад', 'ru'],
            ['subHours', 4, '4 часа назад', 'ru'],
            ['subHours', 5, '5 часов назад', 'ru'],
            ['subHours', 6, '6 часов назад', 'ru'],
            ['subHours', 7, '7 часов назад', 'ru'],
            ['subHours', 8, '8 часов назад', 'ru'],
            ['subHours', 9, '9 часов назад', 'ru'],
            ['subHours', 10, '10 часов назад', 'ru'],
            ['subHours', 11, '11 часов назад', 'ru'],
            ['subHours', 12, '12 часов назад', 'ru'],
            ['subHours', 13, '13 часов назад', 'ru'],
            ['subHours', 14, '14 часов назад', 'ru'],
            ['subHours', 15, '15 часов назад', 'ru'],
            ['subHours', 16, '16 часов назад', 'ru'],
            ['subHours', 17, '17 часов назад', 'ru'],
            ['subHours', 18, '18 часов назад', 'ru'],
            ['subHours', 19, '19 часов назад', 'ru'],
            ['subHours', 20, '20 часов назад', 'ru'],
            ['subHours', 21, '21 час назад', 'ru'],
            ['subHours', 22, '22 часа назад', 'ru'],
            ['subHours', 23, '23 часа назад', 'ru'],
            ['subHours', 24, '1 день назад', 'ru'],
            ['subDays', 2, '2 дня назад', 'ru'],
            ['subDays', 7, '1 неделя назад', 'ru'],
            ['subWeeks', 2, '2 недели назад', 'ru'],
            ['subMonths', 1, '1 месяц назад', 'ru'],
            ['subMonths', 2, '2 месяца назад', 'ru'],
            ['subMonths', 11, '11 месяцев назад', 'ru'],
            ['subMonths', 12, '1 год назад', 'ru'],
            ['subYears', 5, '5 лет назад', 'ru'],
            ['subYears', 21, '21 год назад', 'ru'],
            ['subYears', 30, '30 лет назад', 'ru'],
            ['subYears', 31, '31 год назад', 'ru'],
            ['subYears', 41, '41 год назад', 'ru'],
            ['subYears', 100, '100 лет назад', 'ru'],
            ['subYears', 101, '101 год назад', 'ru'],
        ];
    }

    /**
     * @dataProvider Provider_for_returns_correct_date_in_seconds_in_english
     * @test
     * @param int $seconds
     * @param array $expect
     * @param string $lang
     */
    public function returns_correct_date_in_seconds(int $seconds, array $expect, string $lang): void
    {
        Lang::set($lang);

        $date = CarbonImmutable::now()->subSeconds($seconds)->toDateTimeString();
        $message = sprintf("Expected '%s' or '%s' but got '%s'", $expect[0], $expect[1], $res = Time::ago($date));
        $this->assertTrue(in_array($res, $expect), $message);
    }

    public function Provider_for_returns_correct_date_in_seconds_in_english(): array
    {
        return [
            // english
            [1, ['1 second ago', '2 seconds ago'], 'en'],
            [2, ['2 seconds ago', '3 seconds ago'], 'en'],
            [30, ['30 seconds ago', '31 seconds ago'], 'en'],
            [58, ['58 seconds ago', '59 seconds ago'], 'en'],
            // russian
            [1, ['1 секунда назад', '2 секунды назад'], 'ru'],
            [2, ['2 секунды назад', '3 секунды назад'], 'ru'],
            [5, ['5 секунд назад', '6 секунд назад'], 'ru'],
            [21, ['21 секунда назад', '22 секунды назад'], 'ru'],
        ];
    }
}
