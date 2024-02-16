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
use DateTime;
use DateTimeImmutable;
use Exception;

use function Arokettu\Debug\call_private_method;

class TimeAgoTest extends TestCase
{
    /**
     * @dataProvider providerForGetLanguageFormReturnsCorrectForm
     *
     *
     * @param int $number
     * @param string $expect
     * @param string $lang
     */
    public function testGetLanguageFormReturnsCorrectForm(int $number, string $expect, string $lang): void
    {
        Lang::set($lang);
        $result = call_private_method(TimeAgo::singleton(), 'getLanguageForm', $number);
        $this->assertSame($expect, $result, "Number {$number} has to be {$expect}, {$result} given");
    }

    public function providerForGetLanguageFormReturnsCorrectForm(): array
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


    public function testGetLanguageFormThrowsExceptionIfFormHasNotBeenFound(): void
    {
        $this->expectExceptionMessage("Provided rules don't apply to a number -1");
        call_private_method(TimeAgo::singleton(), 'getLanguageForm', -1);
    }

    /**
     * @dataProvider providerForTransMethodReturnsCorrectResultAfterPassingATimestamp
     *
     */
    public function testTransMethodReturnsCorrectResultAfterPassingATimestamp(int $timestamp, string $expect): void
    {
        $this->assertSame($expect, TimeAgo::trans($timestamp));
    }

    public function providerForTransMethodReturnsCorrectResultAfterPassingATimestamp(): array
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
     * @dataProvider providerForTransMethodReturnsCorrectResultAfterPassingADateTimeObject
     *
     */
    public function testTransMethodReturnsCorrectResultAfterPassingADateTimeObject(
        DateTimeInterface $timestamp,
        string $expect
    ): void {
        $this->assertSame($expect, TimeAgo::trans($timestamp));
    }

    public function providerForTransMethodReturnsCorrectResultAfterPassingADateTimeObject(): array
    {
        return [
            [(new DateTimeImmutable('now - 3 days')), '3 days ago'],
            [(new DateTimeImmutable('now - 2 weeks')), '2 weeks ago'],
            [(new DateTime('now - 4 months')), '4 months ago'],
            [(new DateTime('now - 20 years')), '20 years ago'],
            [(new DateTimeImmutable('now - 5 minutes')), '5 minutes ago'],
        ];
    }

    /**
     * @dataProvider providerForTransMethodReturnsCorrectResultAfterPassingACarbonObject
     *
     */
    public function testTransMethodReturnsCorrectResultAfterPassingACarbonObject(
        CarbonInterface $timestamp,
        string $expect
    ): void {
        $this->assertSame($expect, TimeAgo::trans($timestamp));
    }

    public function providerForTransMethodReturnsCorrectResultAfterPassingACarbonObject(): array
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
     * @dataProvider providerForTransMethodThrowsExceptionIfInputHasIncorrectString
     *
     */
    public function testTransMethodThrowsExceptionIfInputHasIncorrectString(string $input): void
    {
        $this->expectException(InvalidDateFormatException::class);
        TimeAgo::trans($input);
    }

    public function providerForTransMethodThrowsExceptionIfInputHasIncorrectString(): array
    {
        return [
            ['sfdafsd'],
            ['safjldkfj'],
            ['afjdsalkfjdsklfj'],
            ['__'],
        ];
    }

    /**
     * @dataProvider providerForTransMethodReturnsTimesLeftForADateInFuture
     *
     *
     * @param string $date
     * @param string $lang
     * @param string $result
     *
     * @throws Exception
     */
    public function testTransMethodReturnsTimesLeftForADateInFuture(
        string $date,
        string $lang,
        string $result
    ): void {
        Lang::set($lang);
        $this->assertSame($result, TimeAgo::trans($date));
    }

    public function providerForTransMethodReturnsTimesLeftForADateInFuture(): array
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
