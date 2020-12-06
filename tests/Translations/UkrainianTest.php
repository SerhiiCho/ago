<?php

declare(strict_types=1);

namespace Serhii\Tests\Translations;

use Carbon\CarbonImmutable;
use PHPUnit\Framework\TestCase;
use Serhii\Ago\Lang;
use Serhii\Ago\TimeAgo;

class UkrainianTest extends TestCase
{
    private $language = 'uk';

    /**
     * @dataProvider provider_for_returns_correct_time
     * @test
     *
     * @param string $method
     * @param int $time
     * @param string $output_expected
     *
     * @throws \Exception
     */
    public function returns_correct_time(string $method, int $time, string $output_expected): void
    {
        Lang::set($this->language);
        $date = CarbonImmutable::now()->{$method}($time)->toDateTimeString();
        $this->assertSame($output_expected, TimeAgo::trans($date));
    }

    public function provider_for_returns_correct_time(): array
    {
        return [
            ['subSeconds', 60, '1 хвилина назад'],
            ['subMinutes', 1, '1 хвилина назад'],
            ['subMinutes', 2, '2 хвилини назад'],
            ['subMinutes', 3, '3 хвилини назад'],
            ['subMinutes', 4, '4 хвилини назад'],
            ['subMinutes', 5, '5 хвилин назад'],
            ['subMinutes', 6, '6 хвилин назад'],
            ['subMinutes', 7, '7 хвилин назад'],
            ['subMinutes', 8, '8 хвилин назад'],
            ['subMinutes', 9, '9 хвилин назад'],
            ['subMinutes', 10, '10 хвилин назад'],
            ['subMinutes', 11, '11 хвилин назад'],
            ['subMinutes', 12, '12 хвилин назад'],
            ['subMinutes', 13, '13 хвилин назад'],
            ['subMinutes', 59, '59 хвилин назад'],
            ['subMinutes', 60, '1 година назад'],
            ['subHours', 1, '1 година назад'],
            ['subHours', 2, '2 години назад'],
            ['subHours', 3, '3 години назад'],
            ['subHours', 4, '4 години назад'],
            ['subHours', 5, '5 годин назад'],
            ['subHours', 6, '6 годин назад'],
            ['subHours', 7, '7 годин назад'],
            ['subHours', 8, '8 годин назад'],
            ['subHours', 9, '9 годин назад'],
            ['subHours', 10, '10 годин назад'],
            ['subHours', 11, '11 годин назад'],
            ['subHours', 12, '12 годин назад'],
            ['subHours', 13, '13 годин назад'],
            ['subHours', 14, '14 годин назад'],
            ['subHours', 15, '15 годин назад'],
            ['subHours', 16, '16 годин назад'],
            ['subHours', 17, '17 годин назад'],
            ['subHours', 18, '18 годин назад'],
            ['subHours', 19, '19 годин назад'],
            ['subHours', 20, '20 годин назад'],
            ['subHours', 21, '21 година назад'],
            ['subHours', 22, '22 години назад'],
            ['subHours', 23, '23 години назад'],
            ['subHours', 24, '1 день назад'],
            ['subDays', 5, '5 днів назад'],
            ['subDays', 2, '2 дня назад'],
            ['subDays', 7, '1 тиждень назад'],
            ['subWeeks', 2, '2 тижні назад'],
            ['subMonths', 1, '1 місяць назад'],
            ['subMonths', 2, '2 місяці назад'],
            ['subMonths', 11, '11 місяців назад'],
            ['subMonths', 12, '1 рік назад'],
            ['subYears', 5, '5 років назад'],
            ['subYears', 21, '21 рік назад'],
            ['subYears', 30, '30 років назад'],
            ['subYears', 31, '31 рік назад'],
            ['subYears', 41, '41 рік назад'],
            ['subYears', 100, '100 років назад'],
            ['subYears', 101, '101 рік назад'],
        ];
    }

    /**
     * @dataProvider provider_for_returns_correct_date_in_seconds_in_english
     * @test
     *
     * @param int $seconds
     * @param array $expect
     *
     * @throws \Exception
     */
    public function returns_correct_date_in_seconds(int $seconds, array $expect): void
    {
        Lang::set($this->language);

        $date = CarbonImmutable::now()->subSeconds($seconds)->toDateTimeString();
        $message = sprintf("Expected '%s' or '%s' but got '%s'", $expect[0], $expect[1], $res = TimeAgo::trans($date));
        $this->assertContains($res, $expect, $message);
    }

    public function provider_for_returns_correct_date_in_seconds_in_english(): array
    {
        return [
            [1, ['1 секунда назад', '2 секунди назад']],
            [2, ['2 секунди назад', '3 секунди назад']],
            [5, ['5 секунд назад', '6 секунд назад']],
            [21, ['21 секунда назад', '22 секунди назад']],
        ];
    }
}
