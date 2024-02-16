<?php

declare(strict_types=1);

namespace Serhii\Tests;

use Carbon\CarbonImmutable;
use PHPUnit\Framework\TestCase;
use Serhii\Ago\Exceptions\InvalidOptionsException;
use Serhii\Ago\Lang;
use Serhii\Ago\Option;
use Serhii\Ago\TimeAgo;
use Exception;

use function Arokettu\Debug\call_private_method;

class OptionsTest extends TestCase
{
    public function testReturnsOnlineWithin60SecondsIfONLINEOptionsIsSet(): void
    {
        Lang::set('ru');

        for ($i = 0; $i < 60; $i++) {
            $date = CarbonImmutable::now()->subSeconds($i)->toDateTimeString();

            $res = TimeAgo::trans($date, Option::ONLINE);
            $msg = "Expected 'В сети' but result is '{$res}' with input {$date}";

            $this->assertSame('В сети', $res, $msg);
        }
    }


    public function testOptionIsSetReturnsFalseIfProvidedOptionsWasNotPassedToTransMethod(): void
    {
        TimeAgo::trans(CarbonImmutable::now()->toDateTimeString());
        $result = call_private_method(TimeAgo::singleton(), 'optionIsSet', Option::ONLINE);
        $this->assertFalse($result);
    }


    public function testOptionIsSetReturnsTrueIfProvidedOptionsWasPassedToTransMethod(): void
    {
        TimeAgo::trans(CarbonImmutable::now()->toDateTimeString(), Option::ONLINE);
        $result = call_private_method(TimeAgo::singleton(), 'optionIsSet', Option::ONLINE);
        $this->assertTrue($result);
    }

    /**
     *
     * @dataProvider provider_for_returns_time_without_suffix_if_flag_is_passes
     *
     * @param string $lang
     * @param string $time
     * @param string $expect
     *
     * @throws Exception
     */
    public function testReturnsTimeWithoutSuffixIfOptionIsPasses(string $lang, string $time, string $expect): void
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
            ['de', CarbonImmutable::now()->subYear()->toDateTimeString(), '1 Jahr'],
            ['de', CarbonImmutable::now()->subMonth()->toDateTimeString(), '1 Monat'],
            ['de', CarbonImmutable::now()->subMinutes(25)->toDateTimeString(), '25 Minuten'],
            ['de', CarbonImmutable::now()->subMinute()->toDateTimeString(), '1 Minute'],
        ];
    }

    /**
     *
     * @dataProvider provider_returns_time_without_suffix_and_with_online_if_2_options_is_passes
     *
     * @param string $lang
     * @param string $time
     * @param string $expect
     *
     * @throws Exception
     */
    public function testReturnsTimeWithoutSuffixAndWithOnlineIf2OptionsIsPasses(string $lang, string $time, string $expect): void
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
     *
     * @dataProvider provider_for_returns_time_converter_with_2_options
     *
     * @param string $lang
     * @param string $time
     * @param string $expect
     *
     * @throws Exception
     */
    public function testReturnsTimeConverterWith2Options(string $lang, string $time, string $expect): void
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


    public function testReturnsJustNowWithin60SecondsIfJUSTNOWOptionsIsSet(): void
    {
        Lang::set('en');

        for ($i = 0; $i < 60; $i++) {
            $date = CarbonImmutable::now()->subSeconds($i)->toDateTimeString();

            $res = TimeAgo::trans($date, Option::JUST_NOW);
            $msg = "Expected 'Just now' but result is '{$res}' with input {$date}";

            $this->assertSame('Just now', $res, $msg);
        }
    }


    public function testExceptionIsThrownIfOptionOnlineAndOptionJustNowArePassedAtTheSameTime(): void
    {
        $this->expectException(InvalidOptionsException::class);

        $date = strtotime('now - 10 minutes');
        TimeAgo::trans($date, [Option::ONLINE, Option::JUST_NOW]);
    }
}
