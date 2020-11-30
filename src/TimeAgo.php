<?php

declare(strict_types=1);

namespace Serhii\Ago;

use Exception;

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
     *
     * @return string
     * @throws \Exception
     */
    public static function trans(string $date, ?array $options = []): string
    {
        return self::singleton()->handle($date, $options);
    }

    /**
     * @param string $date
     * @param array|null $options
     *
     * @return string
     * @throws \Exception
     */
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
                $online = Lang::trans('online');
                return  mb_strtoupper(mb_substr($online, 0, 1)).mb_substr($online, 1);
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

    /**
     * @param string $type
     * @param int $number
     *
     * @return string
     * @throws \Exception
     */
    private function getWords(string $type, int $number): string
    {
        $form = $this->getLanguageForm($number);

        $time = Lang::getTimeTranslations();

        if ($this->optionIsSet('no-suffix') || $this->optionIsSet('upcoming')) {
            return "$number {$time[$type][$form]}";
        }

        return "$number {$time[$type][$form]} " . Lang::trans('ago');
    }

    /**
     * @param int $number
     *
     * @return string
     * @throws \Exception
     */
    private function getLanguageForm(int $number): string
    {
        $last_digit = (int) substr((string) $number, -1);
        $form = null;

        foreach (Lang::getRules($number, $last_digit) as $form_name => $rules) {
            if (is_bool($rules)) {
                if ($rules) {
                    $form = $form_name;
                }
                continue;
            }

            foreach ($rules as $rule_is_passing) {
                if ($rule_is_passing) {
                    $form = $form_name;
                    break 1;
                }
            }
        }

        if (is_null($form)) {
            throw new Exception("Provided rules don't much any language form for number $number");
        }

        return $form;
    }
}