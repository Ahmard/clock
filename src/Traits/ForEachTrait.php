<?php
declare(strict_types=1);

namespace Clock\Traits;


use Clock\Clock;
use Clock\Exceptions\ClockException;
use Closure;
use Moment\Moment;
use Moment\MomentException;
use React\EventLoop\TimerInterface;
use TypeError;

trait ForEachTrait
{
    /**
     * @param int|Closure $hourOrClosure
     * @param Closure|null $closure
     * @throws ClockException
     * @throws MomentException
     */
    public static function forEachHour($hourOrClosure, ?Closure $closure = null): void
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
            Clock::forEachMinute($hourHandler(($hourOrClosure * 60), $closure));
            return;
        }

        Clock::forEachMinute($hourHandler(60, $hourOrClosure));
    }

    /**
     * @param int|Closure $minuteOrClosure
     * @param Closure|null $closure
     * @throws ClockException
     * @throws MomentException
     */
    public static function forEachMinute($minuteOrClosure, ?Closure $closure = null): void
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
            Clock::forEachSecond($minuteHandler(($minuteOrClosure * 60), $closure));
            return;
        }

        Clock::forEachSecond($minuteHandler(60, $minuteOrClosure));
    }

    /**
     * @param int|Closure $secondOrClosure
     * @param Closure|null $closure
     * @throws ClockException
     * @throws MomentException
     */
    public static function forEachSecond($secondOrClosure, ?Closure $closure = null): void
    {
        if (is_int($secondOrClosure)) {
            if (null == $closure) {
                throw new ClockException('Second parameter must be provided and must not be null');
            }

            self::forEach($secondOrClosure, $closure);
            return;
        }

        Clock::getLoop()->addPeriodicTimer(1, $secondOrClosure);
    }

    /**
     * @param string|int|Moment $moment
     * @param Closure $closure
     * @throws MomentException
     */
    public static function forEach($moment, Closure $closure): void
    {
        $seconds = self::normaliseMoment($moment);
        self::getLoop()->addPeriodicTimer(
            1,
            function (TimerInterface $timer) use ($seconds, $closure) {
                static $counter = 1;

                if ($counter == $seconds) {
                    $counter = 0;
                    $closure($timer);
                }

                $counter++;
            }
        );
    }


    /**
     * @throws MomentException
     * @var string|int|Moment $moment
     * @return int
     */
    protected static function normaliseMoment($moment): int
    {
        switch (gettype($moment)) {
            case Moment::class:
                $seconds = $moment->getTimestamp() - time();
                break;
            case 'string':
                $seconds = (new Moment($moment))->getTimestamp() - time();
                break;
            case 'integer':
            case 'int':
                $seconds = $moment;
                break;
            default:
                throw new TypeError("Value passed to first parameter must be of type string|int|Moment\Moment");
        }

        return $seconds;
    }
}
