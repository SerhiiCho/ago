<?php declare(strict_types=1);

namespace Serhii\Ago;

class Ago
{
    const ONLINE = 1;

    private static $lang = 'en';
    private static $supported_languages = ['en', 'ru'];

    /**
     * @param string $date
     * @param int|null $flag
     * @return string
     */
    public static function take(string $date, ?int $flag = null): string
    {
        $seconds = strtotime('now') - strtotime($date);

        $minutes = (int) round($seconds / 60);
        $hours = (int) round($seconds / 3600);
        $days = (int) round($seconds / 86400);
        $weeks = (int) round($seconds / 604800);
        $months = (int) round($seconds / 2629440);
        $years = (int) round($seconds / 31553280);

        switch (true) {
            case $flag === self::ONLINE && $seconds < 60:
                return self::trans('online');
            case $seconds < 60:
                return self::getWords('seconds', $seconds);
            case $minutes < 60:
                return self::getWords('minutes', $minutes);
            case $hours < 24:
                return self::getWords('hours', $hours);
            case $days < 7:
                return self::getWords('days', $days);
            case $weeks < 4:
                return self::getWords('weeks', $weeks);
            case $months < 12:
                return self::getWords('months', $months);
        }

        return self::getWords('years', $years);
    }

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
    public static function lang(string $lang): void
    {
        self::$lang = in_array($lang, self::$supported_languages) ? $lang : 'en';
    }

    private static function getWords(string $type, int $num): string
    {
        $time = [
            'seconds' => [self::trans('second'), self::trans('seconds'), self::trans('seconds2')],
            'minutes' => [self::trans('minute'), self::trans('minutes'), self::trans('minutes2')],
            'hours' => [self::trans('hour'), self::trans('hours'), self::trans('hours2')],
            'days' => [self::trans('day'), self::trans('days'), self::trans('days2')],
            'weeks' => [self::trans('week'), self::trans('weeks'), self::trans('weeks2')],
            'months' => [self::trans('month'), self::trans('months'), self::trans('months2')],
            'years' => [self::trans('year'), self::trans('years'), self::trans('years2')],
            'decades' => [self::trans('decade'), self::trans('decades'), self::trans('decades2')],
        ];

        $last_num = (int) substr((string) $num, -1);

        switch (true) {
            case $last_num === 1:
                $index = $num === 11 ? 2 : 0;
                break;
            case $last_num > 1 && $last_num < 5:
                $index = 1;
                break;
            default:
                $index = 2;
        }

        return "$num {$time[$type][$index]} " . self::trans('ago');
    }

    private static function trans(string $index): string
    {
        $trans = require_once '';
        return $trans[$index];
    }
}