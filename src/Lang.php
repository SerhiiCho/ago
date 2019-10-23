<?php declare(strict_types=1);

namespace Serhii\Ago;

class Lang
{
    /**
     * @var string
     */
    private static $lang = 'en';

    /**
     * @var array
     */
    private static $supported_languages = ['en', 'ru'];

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
        self::$lang = in_array($lang, self::$supported_languages) ? $lang : 'en';
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

    public static function includeTranslations()
    {
        self::$translations = self::$lang === 'ru'
            ? require __DIR__ . '/lang/ru.php'
            : require __DIR__ . '/lang/en.php';
    }

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