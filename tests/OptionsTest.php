<?php declare(strict_types=1);

namespace Serhii\Tests;

use Carbon\CarbonImmutable;
use ReflectionMethod;
use Serhii\Ago\Time;
use PHPUnit\Framework\TestCase;
use Serhii\Ago\Lang;

class OptionsTest extends TestCase
{
    /**
     * @dataProvider Provider_returns_online_within_60_seconds_and_if_second_arg_is_passes
     * @test
     * @param int $seconds
     * @param string $lang
     */
    public function returns_online_within_60_seconds_if_ONLINE_options_is_set(int $seconds, string $lang): void
    {
        Lang::set($lang);

        $date = CarbonImmutable::now()->subSeconds($seconds)->toDateTimeString();
        $time = Time::ago($date, ['online']);

        $this->assertSame($lang === 'ru' ? 'В сети' : 'Online', $time);
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

    /** @test */
    public function optionIsSet_returns_false_if_provided_options_was_not_passed_to_ago_method(): void
    {
        Time::ago(CarbonImmutable::now()->toDateTimeString());

        $reflect = new ReflectionMethod(Time::class, 'optionIsSet');
        $reflect->setAccessible(true);

        $this->assertFalse($reflect->invoke(new Time, 'online'));
    }

    /** @test */
    public function optionIsSet_returns_true_if_provided_options_was_passed_to_ago_method(): void
    {
        Time::ago(CarbonImmutable::now()->toDateTimeString(), ['online']);

        $reflect = new ReflectionMethod(Time::class, 'optionIsSet');
        $reflect->setAccessible(true);

        $this->assertTrue($reflect->invoke(new Time, 'online'));
    }

    /**
     * @test
     * @dataProvider Provider_for_returns_time_without_suffix_if_flag_is_passes
     * @param $lang
     * @param $time
     * @param $expect
     */
    public function returns_time_without_suffix_if_option_is_passes($lang, $time, $expect): void
    {
        Lang::set($lang);
        $this->assertSame($expect, Time::ago($time, ['no-suffix']));
    }

    public function Provider_for_returns_time_without_suffix_if_flag_is_passes(): array
    {
        return [
            ['en', CarbonImmutable::now()->subMinute()->toDateTimeString(), '1 minute'],
            ['en', CarbonImmutable::now()->subMinutes(25)->toDateTimeString(), '25 minutes'],
            ['en', CarbonImmutable::now()->subMonth()->toDateTimeString(), '1 month'],
            ['en', CarbonImmutable::now()->subYear()->toDateTimeString(), '1 year'],
            ['ru', CarbonImmutable::now()->subMinute()->toDateTimeString(), '1 минута'],
            ['ru', CarbonImmutable::now()->subMinutes(25)->toDateTimeString(), '25 минут'],
            ['ru', CarbonImmutable::now()->subMonth()->toDateTimeString(), '1 месяц'],
            ['ru', CarbonImmutable::now()->subYear()->toDateTimeString(), '1 год'],
        ];
    }

    /**
     * @test
     * @dataProvider Provider_returns_time_without_suffix_and_with_online_if_2_options_is_passes
     * @param $lang
     * @param $time
     * @param $expect
     */
    public function returns_time_without_suffix_and_with_online_if_2_options_is_passes($lang, $time, $expect): void
    {
        Lang::set($lang);
        $this->assertSame($expect, Time::ago($time, ['no-suffix', 'online']));
    }

    public function Provider_returns_time_without_suffix_and_with_online_if_2_options_is_passes(): array
    {
        return [
            ['en', CarbonImmutable::now()->subSeconds(5)->toDateTimeString(), 'Online'],
            ['en', CarbonImmutable::now()->subSeconds(30)->toDateTimeString(), 'Online'],
            ['en', CarbonImmutable::now()->subSeconds(50)->toDateTimeString(), 'Online'],
            ['en', CarbonImmutable::now()->subMinutes(25)->toDateTimeString(), '25 minutes'],
            ['en', CarbonImmutable::now()->subMonth()->toDateTimeString(), '1 month'],
            ['en', CarbonImmutable::now()->subYear()->toDateTimeString(), '1 year'],
            ['ru', CarbonImmutable::now()->subSeconds(5)->toDateTimeString(), 'В сети'],
            ['ru', CarbonImmutable::now()->subSeconds(21)->toDateTimeString(), 'В сети'],
            ['ru', CarbonImmutable::now()->subSeconds(41)->toDateTimeString(), 'В сети'],
            ['ru', CarbonImmutable::now()->subMinutes(25)->toDateTimeString(), '25 минут'],
            ['ru', CarbonImmutable::now()->subMonth()->toDateTimeString(), '1 месяц'],
            ['ru', CarbonImmutable::now()->subYear()->toDateTimeString(), '1 год'],
        ];
    }

    /**
     * @dataProvider Provider_returns_times_left_for_a_date_in_future_with_UPCOMING_option
     * @test
     * @param string $date
     * @param string $lang
     * @param string $result
     */
    public function returns_times_left_for_a_date_in_future_with_UPCOMING_option(string $date, string $lang, string $result): void
    {
        Lang::set($lang);
        $this->assertSame($result, Time::ago($date, ['upcoming']));
    }

    public function Provider_returns_times_left_for_a_date_in_future_with_UPCOMING_option(): array
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
