<?php

use Clock\Clock;
use Clock\Exceptions\ClockException;
use React\EventLoop\Factory;

require 'vendor/autoload.php';

Clock::setLoop(Factory::create());

try {

    Clock::alarm('5 seconds');
} catch (ClockException $e) {
    dd($e->getMessage());
}

Clock::run();