<?php declare(strict_types=1);

namespace Serhii\Ago;

class Time
{
    const ONLINE = 1;
    const NO_SUFFIX = 2;

    private static $flag = 0;

    /**
     * Takes date string and returns converted date
     * into `n time ago`
     *
     * @param string $date
     * @param int|null $flag
     * @return string
     */
    public static function ago(string $date, ?int $flag = null): string
    {
        self::$flag = $flag;

        Lang::includeTranslations();

        $seconds = strtotime('now') - strtotime($date);

        $minutes = (int) round($seconds / 60);
        $hours = (int) round($seconds / 3600);
        $days = (int) round($seconds / 86400);
        $weeks = (int) round($seconds / 604800);
        $months = (int) round($seconds / 2629440);
        $years = (int) round($seconds / 31553280);

        switch (true) {
            case $flag === self::ONLINE && $seconds < 60:
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

    private static function getWords(string $type, int $num): string
    {
        $last_num = (int) substr((string) $num, -1);
        $index = 2;

        switch (true) {
            case $last_num === 1 && $num == 11:
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
        $suffix = self::$flag === self::NO_SUFFIX ? '' : ' ' . Lang::trans('ago');

        return "$num {$time[$type][$index]}" . $suffix;
    }
}