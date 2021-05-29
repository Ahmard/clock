<?php


namespace Clock;


use Clock\Traits\AlarmsTrait;
use Clock\Traits\ForEachTrait;
use Closure;
use Moment\Moment;
use Moment\MomentException;
use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;
use React\EventLoop\TimerInterface;

class Clock
{
    use ForEachTrait;

    use AlarmsTrait;

    protected static LoopInterface $loop;

    /**
     * Set an alarm
     *
     * @param string|Moment $moment
     * @param Closure|null $closure A closure to be called when the alarm is about to sound
     * @throws Exceptions\ClockException
     * @throws MomentException
     */
    public static function alarm($moment, ?Closure $closure = null): void
    {
        if (is_string($moment)) {
            $moment = new Moment($moment);
        }

        $timestamp = $moment->getTimestamp();

        self::forEachSecond(function (TimerInterface $timer) use ($timestamp, $closure) {
            static $passedSeconds = 1;
            if ($timestamp === time()) {
                //Execute closure if some is provided
                if ($closure) {
                    $closure($timer);
                }

                //Sound alarm
                Sound::playAlarm();
                //Cancel the timer
                Clock::getLoop()->cancelTimer($timer);
            }
            $passedSeconds++;
        });
    }

    /**
     * Retrieves event-loop
     *
     * @return LoopInterface
     */
    public static function getLoop(): LoopInterface
    {
        if (!isset(self::$loop)) {
            self::create();
        }

        return self::$loop;
    }

    /**
     * Set your custom event loop
     *
     * @param LoopInterface $loop
     */
    public static function setLoop(LoopInterface $loop): void
    {
        self::$loop = $loop;
    }

    /**
     * Create event-loop
     *
     * @param bool $runOnShutdown Whether to run ReactPHP's event-loop on register_shutdown_function is executed
     */
    public static function create(bool $runOnShutdown = true): LoopInterface
    {
        if (!isset(self::$loop)) {
            self::setLoop(Factory::create());
        }

        if ($runOnShutdown) {
            register_shutdown_function(fn() => self::run());
        }

        return self::getLoop();
    }

    /**
     * Run ReactPHP's event-loop
     */
    public static function run(): void
    {
        if (!isset(self::$loop)) {
            self::create();
        }

        self::$loop->run();
    }

    /**
     * Cancel clock
     *
     * @param TimerInterface $timer
     */
    public static function stop(TimerInterface $timer): void
    {
        self::getLoop()->cancelTimer($timer);
    }
}