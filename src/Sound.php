<?php


namespace Clock;


use React\ChildProcess\Process;

class Sound
{
    public static function playAlarm(): Process
    {
        return self::play(dirname(__DIR__) . '/raw/alarm.wav');
    }

    public static function play(string $filePath): Process
    {
        $process = new Process("play $filePath");
        $process->start(Clock::getLoop());
        return $process;
    }

    public static function playReminder1(): Process
    {
        return self::play(dirname(__DIR__) . '/raw/reminder-1.wav');
    }

    public static function playReminder2(): Process
    {
        return self::play(dirname(__DIR__) . '/raw/reminder-2.wav');
    }

    public static function playNotification1(): Process
    {
        return self::play(dirname(__DIR__) . '/raw/notification-1.wav');
    }

    public static function playNotification2(): Process
    {
        return self::play(dirname(__DIR__) . '/raw/notification-2.wav');
    }
}