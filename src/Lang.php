<?php declare(strict_types=1);

namespace Serhii\Ago;

class Lang
{
    /**
     * @var string
     */
    public static $lang = 'en';

    /**
     * @var null|array
     */
    private static $translations;

    /**
     * Set the language by passing 'ru' or 'en' argument.
     * If given language is not supported by this package,
     * the language will be set to English as default.
     *
     * If you don't call this method, the default
     * language will be set to English.
     *
     * @param string $lang Can be `ru` for Russian language
     * and `en` for English.
     */
    public static function set(string $lang): void
    {
        self::$lang = in_array($lang, ['en', 'ru']) ? $lang : 'en';
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
     * Includes array of translations from lang directory
     * into the $translations variable.
     */
    public static function includeTranslations(): void
    {
        self::$translations = require __DIR__ . '/lang/' . self::$lang . '.php';
    }

    /**
     * Returns array of translations for different cases.
     * For example `1 second` must not have `s` at the end
     * but `2 seconds` requires `s`. So this method keeps
     * all possible options for the translated word.
     *
     * @return array
     */
    public static function getTimeTranslations(): array
    {
        return [
            'seconds' => [self::trans('second'), self::trans('seconds'), self::trans('seconds2')],
            'minutes' => [self::trans('minute'), self::trans('minutes'), self::trans('minutes2')],
            'hours' => [self::trans('hour'), self::trans('hours'), self::trans('hours2')],
            'days' => [self::trans('day'), self::trans('days'), self::trans('days2')],
            'weeks' => [self::trans('week'), self::trans('weeks'), self::trans('weeks2')],
            'months' => [self::trans('month'), self::trans('months'), self::trans('months2')],
            'years' => [self::trans('year'), self::trans('years'), self::trans('years2')],
        ];
    }
}