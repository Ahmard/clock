<?php


namespace Clock\Traits;


use Clock\Exceptions\ClockException;
use React\EventLoop\TimerInterface;
use Closure;

trait ForEachTrait
{
    /**
     * @throws ClockException
     */
    public static function forEachSecond(int|Closure $secondOrClosure, ?Closure $closure = null): void
    {
        if (is_int($secondOrClosure)) {
            if (null == $closure) {
                throw new ClockException('Second parameter must be provided and must not be null');
            }

            self::getLoop()->addPeriodicTimer($secondOrClosure, $closure);
            return;
        }

        self::$loop->addPeriodicTimer(1, $secondOrClosure);
    }


    /**
     * @throws ClockException
     */
    public static function forEachMinute(int|Closure $minuteOrClosure, ?Closure $closure = null): void
    {
        $minuteHandler = function (int $seconds, Closure $closure) {
            return function (TimerInterface $timer) use ($closure, $seconds) {
                static $passedSeconds = 1;
                if ($passedSeconds == $seconds) {
                    $closure($timer);
                    $passedSeconds = 1;
                } else {
                    $passedSeconds++;
                }
            };
        };

        if (is_int($minuteOrClosure)) {
            self::forEachSecond($minuteHandler(($minuteOrClosure * 60), $closure));
            return;
        }

        self::forEachSecond($minuteHandler(60, $minuteOrClosure));
    }


    /**
     * @throws ClockException
     */
    public static function forEachHour(int|Closure $hourOrClosure, ?Closure $closure = null): void
    {
        $hourHandler = function (int $minutes, Closure $closure) {
            return function (TimerInterface $timer) use ($closure, $minutes) {
                static $passedMinutes = 1;
                if ($passedMinutes == $minutes) {
                    $closure($timer);
                    $passedMinutes = 1;
                } else {
                    $passedMinutes++;
                }
            };
        };

        if (is_int($hourOrClosure)) {
            self::forEachMinute($hourHandler(($hourOrClosure * 60), $closure));
            return;
        }

        self::forEachMinute($hourHandler(60, $hourOrClosure));
    }
}