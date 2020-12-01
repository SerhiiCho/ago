<?php

declare(strict_types=1);

namespace Serhii\Tests;

use PHPUnit\Framework\TestCase;
use Serhii\Ago\Lang;
use Serhii\Ago\TimeAgo;

use function SandFox\Debug\call_private_method;

class TimeAgoTest extends TestCase
{
    /**
     * @dataProvider Provider_for_getLanguageForm_returns_correct_form
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

    public function Provider_for_getLanguageForm_returns_correct_form(): array
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
            [0, 'single', 'en'],
            [1, 'single', 'en'],
            [2, 'plural', 'en'],
            [3, 'plural', 'en'],
        ];
    }

    /** @test */
    public function getLanguageForm_throws_exception_if_form_has_not_been_found(): void
    {
        $this->expectExceptionMessage("Provided rules don't much any language form for number -1");
        call_private_method(TimeAgo::singleton(), 'getLanguageForm', -1);
    }
}