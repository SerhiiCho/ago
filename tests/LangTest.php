<?php

declare(strict_types=1);

namespace Serhii\Tests;

use PHPUnit\Framework\TestCase;
use Serhii\Ago\Lang;

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
}
