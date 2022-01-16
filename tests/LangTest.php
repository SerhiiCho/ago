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
    /** @test */
    public function getLanguageSlugs_returns_list_of_all_languages(): void
    {
        $res = call_private_method(Lang::class, 'getLanguagesSlugs');

        $this->assertContains('ru', $res);
        $this->assertContains('en', $res);
        $this->assertContains('uk', $res);
    }

    /** @test */
    public function set_method_is_not_overwriting_when_empty_array_is_passed(): void
    {
        Lang::set('en', []);
        $this->assertSame('Online', TimeAgo::trans('now', [Option::ONLINE]));
    }

    /** @test */
    public function set_method_can_overwrite_one_translation_field(): void
    {
        $expect_str = 'I am here';

        Lang::set('en', ['online' => $expect_str]);

        $this->assertSame($expect_str, TimeAgo::trans('now', [Option::ONLINE]));
    }

    /** @test */
    public function set_method_can_overwrite_four_translation_field(): void
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

    /** @test */
    public function set_method_can_overwrite_multiple_languages(): void
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
