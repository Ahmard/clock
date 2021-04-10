<?php


namespace Clock;


use Clock\Traits\ForEachTrait;
use Closure;
use League\Period\Datepoint;
use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;
use React\EventLoop\TimerInterface;

class Clock
{
    use ForEachTrait;

    protected static LoopInterface $loop;

    public static function create()
    {
        self::setLoop(Factory::create());
    }

    public static function setLoop(LoopInterface $loop)
    {
        self::$loop = $loop;
    }

    public static function getLoop(): LoopInterface
    {
        return self::$loop;
    }

    public static function run(): void
    {
        self::$loop->run();
    }


    public static function alarm(string|Datepoint $datePoint)
    {
        if (is_string($datePoint)) {
            $datePoint = Datepoint::create($datePoint);
        }

        $timestamp = $datePoint->getTimestamp();

        self::forEachSecond(function (TimerInterface $timer) use ($timestamp){
             static $passedSeconds = 1;
             if ($timestamp === time()){
                 //Sound alarm
                 Sound::playAlarm();
                 //Cancel the timer
                 Clock::getLoop()->cancelTimer($timer);
             }
             $passedSeconds++;
        });
    }
}