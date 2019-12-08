<?php declare(strict_types=1);

namespace Serhii\Ago;

class Time
{
    /**
     * @var array $options This property will contain all options that
     * will be passed in ago() method as the second argument. It
     * allows to know what option was passed in any part of this class
     */
    private static $options = [];

    /**
     * Takes date string and returns converted date
     *
     * @param string $date
     * @param array|null $options
     * @return string
     */
    public static function ago(string $date, ?array $options = []): string
    {
        self::$options = $options;

        Lang::includeTranslations();

        $seconds = self::optionIsSet('upcoming')
            ? strtotime($date) - strtotime('now')
            : strtotime('now') - strtotime($date);

        $minutes = (int) round($seconds / 60);
        $hours = (int) round($seconds / 3600);
        $days = (int) round($seconds / 86400);
        $weeks = (int) round($seconds / 604800);
        $months = (int) round($seconds / 2629440);
        $years = (int) round($seconds / 31553280);

        switch (true) {
            case self::optionIsSet('online') && $seconds < 60:
                return Lang::trans('online');
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

    private static function optionIsSet(string $option): bool
    {
        return in_array($option, self::$options);
    }

    private static function getWords(string $type, int $num): string
    {
        $last_num = (int) substr((string) $num, -1);
        $index = 2;

        switch (true) {
            case $num >= 11 && $num <= 20:
                $index = 2;
                break;
            case $num === 1 && Lang::$lang === 'en':
            case $last_num === 1 && Lang::$lang === 'ru':
                $index = 0;
                break;
            case $last_num > 1 && $last_num < 5:
                $index = 1;
        }

        $time = Lang::getTimeTranslations();

        if (self::optionIsSet('no-suffix') || self::optionIsSet('upcoming')) {
            return "$num {$time[$type][$index]}";
        }

        return "$num {$time[$type][$index]} " . Lang::trans('ago');
    }
}