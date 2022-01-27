<?php

declare(strict_types=1);

namespace Serhii\Tests;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;
use Serhii\Ago\Exceptions\InvalidDateFormatException;
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
            [time() - 86400, '1 day ago'],
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
    ): void {
        $this->assertSame($expect, TimeAgo::trans($timestamp));
    }

    public function provider_for_trans_method_returns_correct_result_after_passing_a_DateTime_object(): array
    {
        return [
            [(new \DateTimeImmutable('now - 3 days')), '3 days ago'],
            [(new \DateTimeImmutable('now - 2 weeks')), '2 weeks ago'],
            [(new \DateTime('now - 4 months')), '4 months ago'],
            [(new \DateTime('now - 20 years')), '20 years ago'],
            [(new \DateTimeImmutable('now - 5 minutes')), '5 minutes ago'],
        ];
    }

    /**
     * @dataProvider provider_for_trans_method_returns_correct_result_after_passing_a_Carbon_object
     * @test
     */
    public function trans_method_returns_correct_result_after_passing_a_Carbon_object(
        CarbonInterface $timestamp,
        string $expect
    ): void {
        $this->assertSame($expect, TimeAgo::trans($timestamp));
    }

    public function provider_for_trans_method_returns_correct_result_after_passing_a_Carbon_object(): array
    {
        return [
            [CarbonImmutable::now()->subDays(4), '4 days ago'],
            [CarbonImmutable::now()->subMonths(3), '3 months ago'],
            [Carbon::now()->subMonths(5), '5 months ago'],
            [CarbonImmutable::now()->subYears(21), '21 years ago'],
            [Carbon::now()->subMinutes(6), '6 minutes ago'],
            [Carbon::now()->subMonths(8), '8 months ago'],
        ];
    }

    /**
     * @dataProvider provider_for_trans_method_throws_exception_if_input_has_incorrect_string
     * @test
     */
    public function trans_method_throws_exception_if_input_has_incorrect_string(string $input): void
    {
        $this->expectException(InvalidDateFormatException::class);
        TimeAgo::trans($input);
    }

    public function provider_for_trans_method_throws_exception_if_input_has_incorrect_string(): array
    {
        return [
            ['sfdafsd'],
            ['safjldkfj'],
            ['afjdsalkfjdsklfj'],
            ['__'],
        ];
    }

    /**
     * @dataProvider provider_returns_times_left_for_a_date_in_future_with_UPCOMING_option
     * @test
     *
     * @param string $date
     * @param string $lang
     * @param string $result
     *
     * @throws \Exception
     */
    public function trans_method_returns_times_left_for_a_date_in_future(
        string $date,
        string $lang,
        string $result
    ): void {
        Lang::set($lang);
        $this->assertSame($result, TimeAgo::trans($date));
    }

    public function provider_returns_times_left_for_a_date_in_future_with_UPCOMING_option(): array
    {
        return [
            [CarbonImmutable::now()->addMinutes(2)->toDateTimeString(), 'en', '2 minutes'],
            [CarbonImmutable::now()->addMinutes(10)->toDateTimeString(), 'en', '10 minutes'],
            [CarbonImmutable::now()->addHours(13)->toDateTimeString(), 'en', '13 hours'],
            [CarbonImmutable::now()->addMonth()->toDateTimeString(), 'en', '1 month'],
            [CarbonImmutable::now()->addYears(10)->toDateTimeString(), 'en', '10 years'],
            [CarbonImmutable::now()->addYear()->toDateTimeString(), 'en', '1 year'],
            [CarbonImmutable::now()->addMinutes(2)->toDateTimeString(), 'ru', '2 минуты'],
            [CarbonImmutable::now()->addMinutes(10)->toDateTimeString(), 'ru', '10 минут'],
            [CarbonImmutable::now()->addHours(13)->toDateTimeString(), 'ru', '13 часов'],
            [CarbonImmutable::now()->addMonth()->toDateTimeString(), 'ru', '1 месяц'],
            [CarbonImmutable::now()->addMonths(10)->toDateTimeString(), 'ru', '10 месяцев'],
            [CarbonImmutable::now()->addYears(10)->toDateTimeString(), 'ru', '10 лет'],
            [CarbonImmutable::now()->addYear()->toDateTimeString(), 'ru', '1 год'],
        ];
    }
}