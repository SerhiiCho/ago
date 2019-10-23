<?php declare(strict_types=1);

namespace Tests;

use Carbon\CarbonImmutable;
use Serhii\Ago\Ago;
use PHPUnit\Framework\TestCase;
use Serhii\Ago\Lang;

class AgoTest extends TestCase
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
        $this->assertSame($output_expected, Ago::take($date));
    }

    public function Provider_for_returns_correct_time(): array
    {
        return [
            // english
            ['subSeconds', 60, '1 minute ago', 'en'],
            ['subMinutes', 1, '1 minute ago', 'en'],
            ['subMinutes', 3, '3 minutes ago', 'en'],
            ['subHours', 1, '1 hour ago', 'en'],
            ['subHours', 4, '4 hours ago', 'en'],
            ['subHours', 24, '1 day ago', 'en'],
            ['subDays', 2, '2 days ago', 'en'],
            ['subDays', 7, '1 week ago', 'en'],
            ['subWeeks', 2, '2 weeks ago', 'en'],
            ['subMonths', 1, '1 month ago', 'en'],
            ['subMonths', 2, '2 months ago', 'en'],
            ['subMonths', 11, '11 months ago', 'en'],
            ['subMonths', 12, '1 year ago', 'en'],
            ['subYears', 5, '5 years ago', 'en'],
            ['subYears', 21, '21 year ago', 'en'],
            // russian
            ['subSeconds', 60, '1 минута назад', 'ru'],
            ['subMinutes', 1, '1 минута назад', 'ru'],
            ['subMinutes', 3, '3 минуты назад', 'ru'],
            ['subHours', 1, '1 час назад', 'ru'],
            ['subHours', 4, '4 часа назад', 'ru'],
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
        $message = sprintf("Expected '%s' or '%s' but got '%s'", $expect[0], $expect[1], $res = Ago::take($date));
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

    /**
     * @dataProvider Provider_returns_online_within_60_seconds_and_if_second_arg_is_passes
     * @test
     * @param int $seconds
     * @param string $lang
     */
    public function returns_online_within_60_seconds_and_if_second_arg_is_passes(int $seconds, string $lang): void
    {
        Lang::set($lang);
        $time = Ago::take(CarbonImmutable::now()->subSeconds($seconds)->toDateTimeString(), Ago::ONLINE);
        $this->assertSame($lang === 'ru' ? 'В сети' : 'Online', $time); //TODO: refactore
    }

    public function Provider_returns_online_within_60_seconds_and_if_second_arg_is_passes(): array
    {
        return [
            [1, 'en'],
            [2, 'en'],
            [30, 'en'],
            [20, 'en'],
            [58, 'en'],
            [1, 'ru'],
            [2, 'ru'],
            [20, 'ru'],
            [30, 'ru'],
            [58, 'ru'],
        ];
    }
}
