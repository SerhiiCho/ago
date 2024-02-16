<?php

declare(strict_types=1);

namespace Serhii\Tests\Translations;

use Carbon\CarbonImmutable;
use PHPUnit\Framework\TestCase;
use Serhii\Ago\Lang;
use Serhii\Ago\TimeAgo;
use Exception;

class EnglishTest extends TestCase
{
    private $language = 'en';

    /**
     * @dataProvider providerForReturnsCorrectTimeFromOneMinuteAndAbove
     *
     *
     * @param string $method
     * @param int $time
     * @param string $output_expected
     *
     * @throws Exception
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
            ['subSeconds', 60, '1 minute ago'],
            ['subMinutes', 1, '1 minute ago'],
            ['subMinutes', 2, '2 minutes ago'],
            ['subMinutes', 3, '3 minutes ago'],
            ['subMinutes', 4, '4 minutes ago'],
            ['subMinutes', 5, '5 minutes ago'],
            ['subMinutes', 11, '11 minutes ago'],
            ['subMinutes', 59, '59 minutes ago'],
            ['subMinutes', 60, '1 hour ago'],
            ['subHours', 1, '1 hour ago'],
            ['subHours', 4, '4 hours ago'],
            ['subHours', 13, '13 hours ago'],
            ['subHours', 24, '1 day ago'],
            ['subDays', 2, '2 days ago'],
            ['subDays', 7, '1 week ago'],
            ['subWeeks', 2, '2 weeks ago'],
            ['subMonths', 1, '1 month ago'],
            ['subMonths', 2, '2 months ago'],
            ['subMonths', 11, '11 months ago'],
            ['subMonths', 12, '1 year ago'],
            ['subYears', 5, '5 years ago'],
            ['subYears', 21, '21 years ago'],
            ['subYears', 31, '31 years ago'],
            ['subYears', 41, '41 years ago'],
            ['subYears', 100, '100 years ago'],
            ['subYears', 101, '101 years ago'],
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
    public function testProviderForReturnsCorrectDateFrom0SecondsTo59Seconds(int $seconds, array $expect): void
    {
        Lang::set($this->language);

        $date = CarbonImmutable::now()->subSeconds($seconds)->toDateTimeString();
        $message = sprintf("Expected '%s' or '%s' but got '%s'", $expect[0], $expect[1], $res = TimeAgo::trans($date));
        $this->assertContains($res, $expect, $message);
    }

    public function providerForReturnsCorrectDateFrom0SecondsTo59Seconds(): array
    {
        return [
            [0, ['0 seconds ago', '1 second ago']],
            [1, ['1 second ago', '2 seconds ago']],
            [2, ['2 seconds ago', '3 seconds ago']],
            [30, ['30 seconds ago', '31 seconds ago']],
            [58, ['58 seconds ago', '59 seconds ago']],
        ];
    }
}
