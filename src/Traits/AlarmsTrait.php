<?php


namespace Clock\Traits;


use Clock\Clock;
use Clock\Exceptions\ClockException;
use Clock\Sound;
use Closure;
use Moment\MomentException;
use React\EventLoop\TimerInterface;

trait AlarmsTrait
{

    /**
     * When using your screens give your eyes a break.
     * Use the 20-20-20 rule. Every 20 minutes, take a 20-second break and focus your eyes on something at least 20 feet away.
     * @link https://opto.ca/health-library/the-20-20-20-rule
     *
     * @throws ClockException|MomentException
     */
    public static function alarm202020(?Closure $closure = null): void
    {
        Clock::forEachMinute(20, function (TimerInterface $timer) use ($closure) {
            if ($closure) $closure($timer);

            Sound::playAlarm();
        });
    }
}