<?php

declare(strict_types=1);

namespace Serhii\Tests\Translations;

use Carbon\CarbonImmutable;
use PHPUnit\Framework\TestCase;
use Serhii\Ago\Lang;
use Serhii\Ago\TimeAgo;
use Exception;

class GermanTest extends TestCase
{
    private $language = 'de'; // Change language to 'de' for German

    /**
     * @dataProvider providerForReturnsCorrectTimeFromOneMinuteAndAbove
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
            ['subSeconds', 60, 'Vor 1 Minute'],
            ['subMinutes', 1, 'Vor 1 Minute'],
            ['subMinutes', 2, 'Vor 2 Minuten'],
            ['subMinutes', 3, 'Vor 3 Minuten'],
            ['subMinutes', 4, 'Vor 4 Minuten'],
            ['subMinutes', 5, 'Vor 5 Minuten'],
            ['subMinutes', 11, 'Vor 11 Minuten'],
            ['subMinutes', 59, 'Vor 59 Minuten'],
            ['subMinutes', 60, 'Vor 1 Stunde'],
            ['subHours', 1, 'Vor 1 Stunde'],
            ['subHours', 4, 'Vor 4 Stunden'],
            ['subHours', 13, 'Vor 13 Stunden'],
            ['subHours', 24, 'Vor 1 Tag'],
            ['subDays', 2, 'Vor 2 Tagen'],
            ['subDays', 7, 'Vor 1 Woche'],
            ['subWeeks', 2, 'Vor 2 Wochen'],
            ['subMonths', 1, 'Vor 1 Monat'],
            ['subMonths', 2, 'Vor 2 Monaten'],
            ['subMonths', 11, 'Vor 11 Monaten'],
            ['subMonths', 12, 'Vor 1 Jahr'],
            ['subYears', 5, 'Vor 5 Jahren'],
            ['subYears', 21, 'Vor 21 Jahren'],
            ['subYears', 31, 'Vor 31 Jahren'],
            ['subYears', 41, 'Vor 41 Jahren'],
            ['subYears', 100, 'Vor 100 Jahren'],
            ['subYears', 101, 'Vor 101 Jahren'],
        ];
    }

    /**
     * @dataProvider providerForReturnsCorrectDateFrom0SecondsTo59Seconds
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
            [0, ['Vor 0 Sekunden', 'Vor 1 Sekunde']],
            [1, ['Vor 1 Sekunde', 'Vor 2 Sekunden']],
            [2, ['Vor 2 Sekunden', 'Vor 3 Sekunden']],
            [30, ['Vor 30 Sekunden', 'Vor 31 Sekunden']],
            [58, ['Vor 58 Sekunden', 'Vor 59 Sekunden']],
        ];
    }
}
