<?php

declare(strict_types=1);

namespace Serhii\Ago;

use Carbon\CarbonImmutable;
use Carbon\Exceptions\InvalidFormatException;
use Serhii\Ago\Exceptions\InvalidDateFormatException;
use Serhii\Ago\Exceptions\MissingRuleException;

final class TimeAgo
{
    /**
     * @var int[] $options
     */
    private $options = [];

    /**
     * @var self|null
     */
    private static $instance;

    private function __construct()
    {
    }

    public static function singleton(): self
    {
        Lang::includeTranslations();
        Lang::includeRules();

        return static::$instance ?? (static::$instance = new static());
    }

    /**
     * Takes date string and returns converted date
     *
     * @param int|string|\DateTimeInterface|null $date
     * @param int[]|int|null $options
     *
     * @return string
     * @throws \Serhii\Ago\Exceptions\MissingRuleException
     * @throws \Serhii\Ago\Exceptions\InvalidDateFormatException
     */
    public static function trans($date, $options = []): string
    {
        if (\is_int($options)) {
            $options = [$options];
        }

        try {
            /**
             * @phpstan-ignore-next-line
             * @var int $timestamp
             */
            $timestamp = CarbonImmutable::parse($date)->timestamp;
        } catch (InvalidFormatException $e) {
            throw new InvalidDateFormatException($e->getMessage());
        }

        return self::singleton()->handle($timestamp, $options);
    }

    /**
     * @param int $date_timestamp The timestamp
     * @param int[]|null $options
     *
     * @return string
     * @throws \Serhii\Ago\Exceptions\MissingRuleException
     */
    private function handle(int $date_timestamp, ?array $options = []): string
    {
        $this->options = $options ?? [];

        if ($this->optionIsSet(Option::UPCOMING)) {
            trigger_error(
                'Option::UPCOMING is deprecated. Read more: https://github.com/SerhiiCho/ago/issues/34',
                E_USER_DEPRECATED
            );
        }

        $seconds = \time() - $date_timestamp;

        if ($seconds < 0) {
            $seconds = $date_timestamp - \time();
            $this->options[] = Option::UPCOMING;
        }

        $minutes = (int) \round($seconds / 60);
        $hours = (int) \round($seconds / 3600);
        $days = (int) \round($seconds / 86400);
        $weeks = (int) \round($seconds / 604800);
        $months = (int) \round($seconds / 2629440);
        $years = (int) \round($seconds / 31553280);

        switch (true) {
            case $this->optionIsSet(Option::ONLINE) && $seconds < 60:
                return $this->optionIsSet(Option::UPPER)
                    ? \mb_strtoupper(Lang::trans('online'))
                    : Lang::trans('online');
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

    private function optionIsSet(int $option): bool
    {
        return \in_array($option, $this->options, true);
    }

    /**
     * @param string $type
     * @param int $number
     *
     * @return string
     * @throws \Serhii\Ago\Exceptions\MissingRuleException
     */
    private function getWords(string $type, int $number): string
    {
        $form = $this->getLanguageForm($number);

        $time = Lang::getTimeTranslations();

        $translation = $time[$type][$form];
        $ago = Lang::trans('ago');

        if ($this->optionIsSet(Option::UPPER)) {
            $translation = \mb_strtoupper($translation);
            $ago = \mb_strtoupper($ago);
        }

        if ($this->optionIsSet(Option::NO_SUFFIX) || $this->optionIsSet(Option::UPCOMING)) {
            return "$number $translation";
        }

        return "$number $translation $ago";
    }

    /**
     * @param int $number
     *
     * @return string
     * @throws \Serhii\Ago\Exceptions\MissingRuleException
     */
    private function getLanguageForm(int $number): string
    {
        $last_digit = (int) \substr((string) $number, -1);

        /**
         * @var string $form_name
         * @var bool|bool[] $rules
         */
        foreach (Lang::getRules($number, $last_digit) as $form_name => $rules) {
            if (\is_bool($rules) && $rules) {
                return $form_name;
            }

            if (\is_array($rules)) {
                foreach ($rules as $rule_is_passing) {
                    if ($rule_is_passing) {
                        return $form_name;
                    }
                }
            }
        }

        throw new MissingRuleException("Provided rules don't apply to a number $number");
    }
}
