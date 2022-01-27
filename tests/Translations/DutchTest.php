<?php

declare(strict_types=1);

namespace Serhii\Tests\Translations;

use Carbon\CarbonImmutable;
use PHPUnit\Framework\TestCase;
use Serhii\Ago\Lang;
use Serhii\Ago\TimeAgo;

class DutchTest extends TestCase
{
    private $language = 'nl';

    /**
     * @dataProvider provider_for_returns_correct_time_from_one_minute_and_above
     * @test
     *
     * @param string $method
     * @param int $time
     * @param string $output_expected
     *
     * @throws \Exception
     */
    public function returns_correct_time_from_one_minute_and_above(string $method, int $time, string $output_expected): void
    {
        Lang::set($this->language);
        $date = CarbonImmutable::now()->{$method}($time)->toDateTimeString();
        $this->assertSame($output_expected, TimeAgo::trans($date));
    }

    public function provider_for_returns_correct_time_from_one_minute_and_above(): array
    {
        return [
            ['subMinutes', 1, '1 minuut geleden'],
            ['subMinutes', 2, '2 minuten geleden'],
            ['subMinutes', 3, '3 minuten geleden'],
            ['subMinutes', 4, '4 minuten geleden'],
            ['subMinutes', 5, '5 minuten geleden'],
            ['subMinutes', 6, '6 minuten geleden'],
            ['subMinutes', 7, '7 minuten geleden'],
            ['subMinutes', 8, '8 minuten geleden'],
            ['subMinutes', 9, '9 minuten geleden'],
            ['subMinutes', 10, '10 minuten geleden'],
            ['subMinutes', 11, '11 minuten geleden'],
            ['subMinutes', 50, '50 minuten geleden'],
            ['subMinutes', 55, '55 minuten geleden'],
            ['subMinutes', 59, '59 minuten geleden'],
            ['subMinutes', 60, '1 uur geleden'],
            ['subHours', 1, '1 uur geleden'],
            ['subHours', 2, '2 uur geleden'],
            ['subHours', 3, '3 uur geleden'],
            ['subHours', 4, '4 uur geleden'],
            ['subHours', 13, '13 uur geleden'],
            ['subHours', 24, '1 dag geleden'],
            ['subDays', 2, '2 dagen geleden'],
            ['subDays', 3, '3 dagen geleden'],
            ['subDays', 7, '1 week geleden'],
            ['subWeeks', 2, '2 weken geleden'],
            ['subMonths', 1, '1 maand geleden'],
            ['subMonths', 2, '2 maanden geleden'],
            ['subMonths', 11, '11 maanden geleden'],
            ['subMonths', 12, '1 jaar geleden'],
            ['subYears', 5, '5 jaar geleden'],
            ['subYears', 21, '21 jaar geleden'],
            ['subYears', 31, '31 jaar geleden'],
            ['subYears', 41, '41 jaar geleden'],
            ['subYears', 100, '100 jaar geleden'],
            ['subYears', 101, '101 jaar geleden'],
        ];
    }

    /**
     * @dataProvider provider_for_provider_for_returns_correct_date_from_0_seconds_to_59_seconds
     * @test
     *
     * @param int $seconds
     * @param array $expect
     *
     * @throws \Exception
     */
    public function provider_for_returns_correct_date_from_0_seconds_to_59_seconds(int $seconds, array $expect): void
    {
        Lang::set($this->language);

        $date = CarbonImmutable::now()->subSeconds($seconds)->toDateTimeString();
        $message = sprintf("Expected '%s' or '%s' but got '%s'", $expect[0], $expect[1], $res = TimeAgo::trans($date));
        $this->assertContains($res, $expect, $message);
    }

    public function provider_for_provider_for_returns_correct_date_from_0_seconds_to_59_seconds(): array
    {
        return [
            [0, ['0 seconden geleden', '1 seconde geleden']],
            [1, ['1 seconde geleden', '2 seconden geleden']],
            [2, ['2 seconden geleden', '3 seconden geleden']],
            [30, ['30 seconden geleden', '31 seconden geleden']],
            [58, ['58 seconden geleden', '59 seconden geleden']],
        ];
    }
}
