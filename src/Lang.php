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
     * @var string[]|null
     */
    private static $translations;

    /**
     * @var callable|null
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
        self::$lang = \in_array($lang, self::getLanguagesSlugs()) ? $lang : 'en';
    }

    /**
     * @param string $index The key name of the translation
     * @return string Needed translation for current language,
     * if translation not found returns empty string.
     */
    public static function trans(string $index): string
    {
        return self::$translations[$index] ?? '';
    }

    /**
     * @param int $number
     * @param int $last_digit
     *
     * @return bool[]|array[]
     */
    public static function getRules(int $number, int $last_digit): array
    {
        if (!self::$rules) {
            return [];
        }

        return \call_user_func(self::$rules, $number, $last_digit);
    }

    /**
     * @return string[]
     */
    private static function getLanguagesSlugs(): array
    {
        $paths = \glob(__DIR__ . '/../resources/lang/*.php');

        if ($paths === false) {
            return [];
        }

        return \array_map(static function ($path) {
            $chunks = \explode('/', $path);
            $file = \end($chunks);
            return \str_replace('.php', '', $file);
        }, $paths);
    }

    /**
     * Includes array of translations from lang directory
     * into the $translations variable.
     */
    public static function includeTranslations(): void
    {
        self::$translations = require __DIR__ . '/../resources/lang/' . self::$lang . '.php';
    }

    /**
     * Includes array of rules from rules directory
     * into the $rules variable.
     */
    public static function includeRules(): void
    {
        self::$rules = require __DIR__ . '/../resources/rules/' . self::$lang . '.php';
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
            'seconds' => [
                'single' => self::trans('second'),
                'plural' => self::trans('seconds'),
                'special' => self::trans('seconds-special'),
            ],
            'minutes' => [
                'single' => self::trans('minute'),
                'plural' => self::trans('minutes'),
                'special' => self::trans('minutes-special'),
            ],
            'hours' => [
                'single' => self::trans('hour'),
                'plural' => self::trans('hours'),
                'special' => self::trans('hours-special'),
            ],
            'days' => [
                'single' => self::trans('day'),
                'plural' => self::trans('days'),
                'special' => self::trans('days-special'),
            ],
            'weeks' => [
                'single' => self::trans('week'),
                'plural' => self::trans('weeks'),
                'special' => self::trans('weeks-special'),
            ],
            'months' => [
                'single' => self::trans('month'),
                'plural' => self::trans('months'),
                'special' => self::trans('months-special'),
            ],
            'years' => [
                'single' => self::trans('year'),
                'plural' => self::trans('years'),
                'special' => self::trans('years-special'),
            ],
        ];
    }
}
