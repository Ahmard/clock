<?php

use Clock\Clock;
use Clock\Exceptions\ClockException;

require 'vendor/autoload.php';

Clock::create();

try {

    Clock::alarm202020();

} catch (ClockException $e) {
    echo $e;
}

dump('Reminder system started');
Clock::run();