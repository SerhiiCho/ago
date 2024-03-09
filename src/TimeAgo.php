<?php

declare(strict_types=1);

namespace Serhii\Ago;

use Carbon\CarbonImmutable;
use Carbon\Exceptions\InvalidFormatException;
use DateTimeInterface;
use Serhii\Ago\Exceptions\InvalidDateFormatException;
use Serhii\Ago\Exceptions\InvalidOptionsException;
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

        return self::$instance ?? (self::$instance = new self());
    }

    /**
     * Takes date string and returns converted date
     *
     * @param int|string|DateTimeInterface|null $date
     * @param int[]|int|null $options
     *
     * @return string
     * @throws MissingRuleException
     * @throws InvalidDateFormatException
     * @throws InvalidOptionsException
     */
    public static function trans($date, $options = []): string
    {
        if (is_int($options)) {
            $options = [$options];
        }

        try {
            $timestamp = (int) CarbonImmutable::parse($date)->timestamp;
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
     * @throws MissingRuleException
     * @throws InvalidOptionsException
     */
    private function handle(int $date_timestamp, ?array $options = []): string
    {
        $this->options = $options ?? [];

        $this->validateOptions();

        $seconds = time() - $date_timestamp;

        if ($seconds < 0) {
            $seconds = $date_timestamp - time();
            $this->options[] = Option::UPCOMING;
        }

        $minutes = (int) round($seconds / 60);
        $hours = (int) round($seconds / 3600);
        $days = (int) round($seconds / 86400);
        $weeks = (int) round($seconds / 604800);
        $months = (int) round($seconds / 2629440);
        $years = (int) round($seconds / 31553280);

        switch (true) {
            case $this->optionIsSet(Option::ONLINE) && $seconds < 60:
                return Lang::trans('online');
            case $this->optionIsSet(Option::JUST_NOW) && $seconds < 60:
                return Lang::trans('just_now');
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
        return in_array($option, $this->options, true);
    }

    /**
     * @param string $type
     * @param int $number
     *
     * @return string
     * @throws MissingRuleException
     */
    private function getWords(string $type, int $number): string
    {
        $form = $this->getLanguageForm($number);

        $time = Lang::getTimeTranslations();

        $translation = $time[$type][$form];
        $ago = Lang::trans('ago');

        if ($this->optionIsSet(Option::NO_SUFFIX) || $this->optionIsSet(Option::UPCOMING)) {
            return "{$number} {$translation}";
        }

        if (Lang::$lang === 'de') {
            return "{$ago} {$number} {$translation}";
        }

        return "{$number} {$translation} {$ago}";
    }

    /**
     * @param int $number
     *
     * @return string
     * @throws MissingRuleException
     */
    private function getLanguageForm(int $number): string
    {
        $last_digit = (int) substr((string) $number, -1);

        /**
         * @var string $form_name
         * @var bool|bool[] $rules
         */
        foreach (Lang::getRules($number, $last_digit) as $form_name => $rules) {
            if ($this->ruleIsTrue($rules)) {
                return $form_name;
            }
        }

        throw new MissingRuleException("Provided rules don't apply to a number {$number}");
    }

    /**
     * @param bool[]|bool $rules
     *
     * @return bool
     */
    private function ruleIsTrue($rules): bool
    {
        return $this->ruleIsBooleanTrue($rules) || $this->ruleIsArrayWithTrueItem($rules);
    }

    /**
     * @param bool[]|bool $rules
     *
     * @return bool
     */
    private function ruleIsBooleanTrue($rules): bool
    {
        return is_bool($rules) && $rules;
    }

    /**
     * @param bool[]|bool $rules
     *
     * @return bool
     */
    private function ruleIsArrayWithTrueItem($rules): bool
    {
        return is_array($rules) && in_array(true, $rules, true);
    }

    /**
     * @throws InvalidOptionsException
     */
    private function validateOptions(): void
    {
        if ($this->optionIsSet(Option::UPCOMING)) {
            $msg = 'Option::UPCOMING is deprecated. Read more: https://github.com/SerhiiCho/ago/issues/34';
            trigger_error($msg, E_USER_DEPRECATED);
        }

        if ($this->optionIsSet(Option::JUST_NOW) && $this->optionIsSet(Option::ONLINE)) {
            throw new InvalidOptionsException('Option JUST_NOW and ONLINE are incompatible. Use only one of them');
        }
    }
}
