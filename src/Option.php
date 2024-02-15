<?php

declare(strict_types=1);

namespace Serhii\Ago;

class Option
{
    /**
     * Display "Online" if date interval within 60 seconds.
     * After 60 seconds output will be the same as usually "x time ago" format.
     * Incompatible with option JUST_NOW.
     */
    public const ONLINE = 1;

    /**
     * This option has no effect anymore if you try to use it.
     * Behavior of this option is the same as default behavior, so there is no need to use
     * this option anymore.
     */
    public const UPCOMING = 2;

    /**
     * Remove suffix from date and have "5 minutes" instead of "5 minutes ago".
     */
    public const NO_SUFFIX = 3;

    /**
     * Prints Just now when time is within 1 minutes.
     * For example instead of 34 seconds ago it will print Just now.
     * Incompatible with option ONLINE.
     */
    public const JUST_NOW = 4;
}
