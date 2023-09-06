<?php

declare(strict_types=1);

namespace Serhii\Tests;

use Carbon\CarbonImmutable;
use PHPUnit\Framework\TestCase;
use Serhii\Ago\Lang;
use Serhii\Ago\Option;
use Serhii\Ago\TimeAgo;

use function SandFox\Debug\call_private_method;

class LangTest extends TestCase
{
    public function testGetLanguageSlugsReturnsListOfAllLanguages(): void
    {
        $res = call_private_method(Lang::class, 'getLanguagesSlugs');

        $this->assertContains('ru', $res);
        $this->assertContains('en', $res);
        $this->assertContains('uk', $res);
    }


    public function testSetMethodIsNotOverwritingWhenEmptyArrayIsPassed(): void
    {
        Lang::set('en', []);
        $this->assertSame('Online', TimeAgo::trans('now', [Option::ONLINE]));
    }


    public function testSetMethodCanOverwriteOneTranslationField(): void
    {
        $expect_str = 'I am here';

        Lang::set('en', ['online' => $expect_str]);

        $this->assertSame($expect_str, TimeAgo::trans('now', [Option::ONLINE]));
    }


    public function testSetMethodCanOverwriteFourTranslationField(): void
    {
        Lang::set('en', [
            'minutes' => 'MiNuTeS',
            'day' => 'DaY',
            'year' => 'YeaR',
            'ago' => 'AgO',
        ]);

        $now = CarbonImmutable::now();

        $this->assertSame('10 MiNuTeS AgO', TimeAgo::trans($now->subMinutes(10)->toDateTimeString()));
        $this->assertSame('1 DaY AgO', TimeAgo::trans($now->subDay()->toDateTimeString()));
        $this->assertSame('1 YeaR AgO', TimeAgo::trans($now->subYear()->toDateTimeString()));
    }


    public function testSetMethodCanOverwriteMultipleLanguages(): void
    {
        $now = CarbonImmutable::now();

        Lang::set('en', [
            'minute' => 'MiNuTE',
            'day' => 'daY',
        ]);

        $this->assertSame('1 MiNuTE ago', TimeAgo::trans($now->subMinute()->toDateTimeString()));
        $this->assertSame('1 daY ago', TimeAgo::trans($now->subDay()->toDateTimeString()));

        Lang::set('ru', [
            'minute' => 'МинуТА',
            'day' => 'ДЕнь',
        ]);

        $this->assertSame('1 МинуТА назад', TimeAgo::trans($now->subMinute()->toDateTimeString()));
        $this->assertSame('1 ДЕнь назад', TimeAgo::trans($now->subDay()->toDateTimeString()));
    }
}
