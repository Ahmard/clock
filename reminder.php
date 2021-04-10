<?php

use Clock\Clock;
use Clock\Exceptions\ClockException;
use Clock\Sound;

require 'vendor/autoload.php';

Clock::create();

try {
    Clock::forEachMinute(20, function () {
        dump('Sounding alarm...');
        Sound::playReminder1();
    });

} catch (ClockException $e) {
    echo $e;
}

dump('Reminder system started');
Clock::run();