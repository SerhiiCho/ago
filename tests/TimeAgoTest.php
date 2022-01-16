<?php

declare(strict_types=1);

namespace Serhii\Tests;

use Carbon\CarbonImmutable;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;
use Serhii\Ago\Lang;
use Serhii\Ago\TimeAgo;

use function SandFox\Debug\call_private_method;

class TimeAgoTest extends TestCase
{
    /**
     * @dataProvider provider_for_getLanguageForm_returns_correct_form
     * @test
     *
     * @param int $number
     * @param string $expect
     * @param string $lang
     */
    public function getLanguageForm_returns_correct_form(int $number, string $expect, string $lang): void
    {
        Lang::set($lang);
        $result = call_private_method(TimeAgo::singleton(), 'getLanguageForm', $number);
        $this->assertSame($expect, $result, "Number $number has to be $expect, $result given");
    }

    public function provider_for_getLanguageForm_returns_correct_form(): array
    {
        return [
            [0, 'special', 'ru'],
            [1, 'single', 'ru'],
            [2, 'plural', 'ru'],
            [3, 'plural', 'ru'],
            [4, 'plural', 'ru'],
            [5, 'special', 'ru'],
            [20, 'special', 'ru'],
            [21, 'single', 'ru'],
            [0, 'plural', 'en'],
            [1, 'single', 'en'],
            [2, 'plural', 'en'],
            [3, 'plural', 'en'],
        ];
    }

    /** @test */
    public function getLanguageForm_throws_exception_if_form_has_not_been_found(): void
    {
        $this->expectExceptionMessage("Provided rules don't apply to a number -1");
        call_private_method(TimeAgo::singleton(), 'getLanguageForm', -1);
    }

    /**
     * @dataProvider provider_for_getLanguageForm_throws_exception_if_form_has_not_been_found
     * @test
     */
    public function trans_method_returns_correct_result_after_passing_a_timestamp(int $timestamp, string $expect): void
    {
        $this->assertSame($expect, TimeAgo::trans($timestamp));
    }

    public function provider_for_getLanguageForm_throws_exception_if_form_has_not_been_found(): array
    {
        return [
            [CarbonImmutable::now()->subDay()->timestamp, '1 day ago'],
            [CarbonImmutable::now()->subWeek()->timestamp, '1 week ago'],
            [CarbonImmutable::now()->subMonths(5)->timestamp, '5 months ago'],
            [CarbonImmutable::now()->subYears(30)->timestamp, '30 years ago'],
            [CarbonImmutable::now()->subMinutes(3)->timestamp, '3 minutes ago'],
        ];
    }

    /**
     * @dataProvider provider_for_trans_method_returns_correct_result_after_passing_a_DateTime_object
     * @test
     */
    public function trans_method_returns_correct_result_after_passing_a_DateTime_object(
        DateTimeInterface $timestamp,
        string $expect
    ): void
    {
        $this->assertSame($expect, TimeAgo::trans($timestamp));
    }

    public function provider_for_trans_method_returns_correct_result_after_passing_a_DateTime_object(): array
    {
        return [
            [CarbonImmutable::now()->subDays(3)->toDateTime(), '3 days ago'],
            [CarbonImmutable::now()->subWeeks(2)->toDateTimeImmutable(), '2 weeks ago'],
            [CarbonImmutable::now()->subMonths(4)->toDateTime(), '4 months ago'],
            [CarbonImmutable::now()->subYears(20)->toDateTimeImmutable(), '20 years ago'],
            [CarbonImmutable::now()->subMinutes(5)->toDateTime(), '5 minutes ago'],
        ];
    }
}