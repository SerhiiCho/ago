<?php

declare(strict_types=1);

namespace Serhii\Ago;

class Lang
{
    /**
     * @var string
     */
    public static $lang = 'en';

    /**
     * @var null|string[]
     */
    private static $translations;

    /**
     * @var null|array[]
     */
    private static $rules;

    /**
     * Set the language by passing short representation of a language
     * like 'ru' for russian or 'en' for english.
     * If given language is not supported by this package,
     * the language will be set to English as default.
     *
     * If you don't call this method, the default
     * language will be set to English.
     *
     * @param string $lang
     */
    public static function set(string $lang): void
    {
        self::$lang = in_array($lang, self::getLanguagesSlugs()) ? $lang : 'en';
    }

    /**
     * @param string $index The key name of the translation
     * @return string|null Needed translation for current language,
     * if translation not found returns null
     */
    public static function trans(string $index): ?string
    {
        return self::$translations[$index] ?? null;
    }

    /**
     * @return array[]
     */
    public static function getRules(): array
    {
        return self::$rules;
    }

    /**
     * @return string[]
     */
    private static function getLanguagesSlugs(): array
    {
        $paths = glob(__DIR__ . '/lang/*.php');

        return array_map(function ($path) {
            $chunks = explode('/', $path);
            $file = end($chunks);
            return str_replace('.php', '', $file);
        }, $paths);
    }

    /**
     * Includes array of translations from lang directory
     * into the $translations variable.
     */
    public static function includeTranslations(): void
    {
        self::$translations = require __DIR__ . '/lang/' . self::$lang . '.php';
    }

    /**
     * Includes array of rules from rules directory
     * into the $rules variable.
     */
    public static function includeRules(): void
    {
        self::$rules = require __DIR__ . '/rules/' . self::$lang . '.php';
    }

    /**
     * Returns array of translations for different cases.
     * For example `1 second` must not have `s` at the end
     * but `2 seconds` requires `s`. So this method keeps
     * all possible options for the translated word.
     *
     * @return array[]
     */
    public static function getTimeTranslations(): array
    {
        return [
            'seconds' => [self::trans('second'), self::trans('seconds'), self::trans('seconds-special')],
            'minutes' => [self::trans('minute'), self::trans('minutes'), self::trans('minutes-special')],
            'hours' => [self::trans('hour'), self::trans('hours'), self::trans('hours-special')],
            'days' => [self::trans('day'), self::trans('days'), self::trans('days-special')],
            'weeks' => [self::trans('week'), self::trans('weeks'), self::trans('weeks-special')],
            'months' => [self::trans('month'), self::trans('months'), self::trans('months-special')],
            'years' => [self::trans('year'), self::trans('years'), self::trans('years-special')],
        ];
    }
}