<?php

use Clock\Clock;
use Clock\Exceptions\ClockException;
use Clock\Sound;

require 'vendor/autoload.php';

try {

    Clock::forEachSecond(2, function () {
        static $counter = 1;

        // Display message to console
        dump("$counter. Sounding...");

        // Play sound
        Sound::playReminder1();

        $counter++;
    });

} catch (ClockException $e) {
    echo "Exception: {$e->getMessage()}";
}