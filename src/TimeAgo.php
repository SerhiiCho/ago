<?php

declare(strict_types=1);

namespace Serhii\Ago;

class TimeAgo
{
    /**
     * @var array $options This property will contain all options that
     * will be passed in trans() method as the second argument. It
     * allows to know what option was passed in any part of this class
     */
    private $options = [];

    /**
     * @var self|null
     */
    private static $instance;

    private function __construct() {}

    public static function singleton(): self
    {
        return static::$instance ?? (static::$instance = new static());
    }

    /**
     * Takes date string and returns converted date
     *
     * @param string $date
     * @param array|null $options
     * @return string
     */
    public static function trans(string $date, ?array $options = []): string
    {
        return self::singleton()->handle($date, $options);
    }

    private function handle(string $date, ?array $options = []): string
    {
        $this->options = $options;

        Lang::includeTranslations();
        Lang::includeRules();

        $seconds = $this->optionIsSet('upcoming')
            ? strtotime($date) - strtotime('now')
            : strtotime('now') - strtotime($date);

        $minutes = (int) round($seconds / 60);
        $hours = (int) round($seconds / 3600);
        $days = (int) round($seconds / 86400);
        $weeks = (int) round($seconds / 604800);
        $months = (int) round($seconds / 2629440);
        $years = (int) round($seconds / 31553280);

        switch (true) {
            case $this->optionIsSet('online') && $seconds < 60:
                return Lang::trans('online');
            case $seconds < 60:
                return $this->getWords('seconds', $seconds);
            case $minutes < 60:
                return $this->getWords('minutes', $minutes);
            case $hours < 24:
                return $this->getWords('hours', $hours);
            case $days < 7:
                return $this->getWords('days', $days);
            case $weeks < 4:
                return $this->getWords('weeks', $weeks);
            case $months < 12:
                return $this->getWords('months', $months);
        }

        return $this->getWords('years', $years);
    }

    private function optionIsSet(string $option): bool
    {
        return in_array($option, $this->options);
    }

    private function getWords(string $type, int $number): string
    {
        $last_digit = (int) substr((string) $number, -1);
        $index = 0;

        foreach (Lang::getRules($number, $last_digit) as $form_name => $rules) {
            foreach ($rules as $rule_is_passing) {
                switch (true) {
                    case $form_name === 'single' && $rule_is_passing:
                        $index = 0;
                        break 2;
                    case $form_name === 'plural' && $rule_is_passing:
                        $index = 1;
                        break 2;
                    case $form_name === 'special' && $rule_is_passing:
                        $index = 2;
                        break 2;
                }
            }
        }

        $time = Lang::getTimeTranslations();

        if ($this->optionIsSet('no-suffix') || $this->optionIsSet('upcoming')) {
            return "$number {$time[$type][$index]}";
        }

        return "$number {$time[$type][$index]} " . Lang::trans('ago');
    }
}