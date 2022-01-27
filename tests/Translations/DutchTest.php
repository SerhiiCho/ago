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
            ['subHours', 1, '1 uur geleden'],
            ['subHours', 2, '2 uur geleden'],
            ['subDays', 1, '1 dag geleden'],
            ['subDays', 2, '2 dagen geleden'],
            ['subWeeks', 1, '1 week geleden'],
            ['subWeeks', 2, '2 weken geleden'],
            ['subMonths', 1, '1 maand geleden'],
            ['subMonths', 2, '2 maanden geleden'],
            ['subYears', 1, '1 jaar geleden'],
            ['subYears', 2, '2 jaar geleden'],
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
        ];
    }
}
