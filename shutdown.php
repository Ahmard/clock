<?php

use Clock\Clock;
use Clock\Exceptions\ClockException;

require 'vendor/autoload.php';

try {

    Clock::forEachSecond(function () {
        static $count = 1;
        dump($count);
        $count++;
    });

    Clock::alarm('5 seconds', function (){
        dump('Sounding alarm...');
    });

} catch (ClockException $e) {
    echo $e;
}