<?php

declare(strict_types=1);

namespace Serhii\Tests;

use Carbon\CarbonImmutable;
use PHPUnit\Framework\TestCase;
use Serhii\Ago\Lang;
use Serhii\Ago\Option;
use Serhii\Ago\TimeAgo;

use function SandFox\Debug\call_private_method;

class OptionsTest extends TestCase
{
    /** @test */
    public function returns_online_within_60_seconds_if_ONLINE_options_is_set(): void
    {
        Lang::set('ru');

        for ($i = 0; $i < 60; $i++) {
            $date = CarbonImmutable::now()->subSeconds($i)->toDateTimeString();
            $this->assertSame('В сети', TimeAgo::trans($date, Option::ONLINE));
        }
    }

    /** @test */
    public function optionIsSet_returns_false_if_provided_options_was_not_passed_to_trans_method(): void
    {
        TimeAgo::trans(CarbonImmutable::now()->toDateTimeString());
        $result = call_private_method(TimeAgo::singleton(), 'optionIsSet', Option::ONLINE);
        $this->assertFalse($result);
    }

    /** @test */
    public function optionIsSet_returns_true_if_provided_options_was_passed_to_trans_method(): void
    {
        TimeAgo::trans(CarbonImmutable::now()->toDateTimeString(), Option::ONLINE);
        $result = call_private_method(TimeAgo::singleton(), 'optionIsSet', Option::ONLINE);
        $this->assertTrue($result);
    }

    /**
     * @test
     * @dataProvider provider_for_returns_time_without_suffix_if_flag_is_passes
     *
     * @param string $lang
     * @param string $time
     * @param string $expect
     *
     * @throws \Exception
     */
    public function returns_time_without_suffix_if_option_is_passes(string $lang, string $time, string $expect): void
    {
        Lang::set($lang);
        $this->assertSame($expect, TimeAgo::trans($time, Option::NO_SUFFIX));
    }

    public function provider_for_returns_time_without_suffix_if_flag_is_passes(): array
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
     * @dataProvider provider_returns_time_without_suffix_and_with_online_if_2_options_is_passes
     *
     * @param string $lang
     * @param string $time
     * @param string $expect
     *
     * @throws \Exception
     */
    public function returns_time_without_suffix_and_with_online_if_2_options_is_passes(string $lang, string $time, string $expect): void
    {
        Lang::set($lang);
        $this->assertSame($expect, TimeAgo::trans($time, [Option::NO_SUFFIX, Option::ONLINE]));
    }

    public function provider_returns_time_without_suffix_and_with_online_if_2_options_is_passes(): array
    {
        return [
            ['en', CarbonImmutable::now()->toDateTimeString(), 'Online'],
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
     * @test
     * @dataProvider provider_for_returns_time_converter_with_2_options
     *
     * @param string $lang
     * @param string $time
     * @param string $expect
     *
     * @throws \Exception
     */
    public function returns_time_converter_with_2_options(string $lang, string $time, string $expect): void
    {
        Lang::set($lang);
        $result = TimeAgo::trans($time, [Option::NO_SUFFIX, Option::ONLINE]);
        $this->assertSame($expect, $result);
    }

    public function provider_for_returns_time_converter_with_2_options(): array
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
}
