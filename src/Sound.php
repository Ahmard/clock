<?php


namespace Clock;


use React\ChildProcess\Process;

class Sound
{
    public static function play(string $filePath): Process
    {
        $process = new Process("play $filePath");
        $process->start(Clock::getLoop());
        return $process;
    }

    public static function playAlarm(): Process
    {
        return self::play(dirname(__DIR__, 1) . '/raw/alarm.wav');
    }

    public static function playReminder1(): Process
    {
        return self::play(dirname(__DIR__, 1) . '/raw/reminder-1.wav');
    }

    public static function playReminder2(): Process
    {
        return self::play(dirname(__DIR__, 1) . '/raw/reminder-2.wav');
    }
}