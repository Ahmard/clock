<?php

use Clock\Clock;
use Clock\Exceptions\ClockException;
use Moment\MomentException;

require 'vendor/autoload.php';

try {

    Clock::forEach('5 seconds', function () {
        dump(time(),'2 minutes have passed');
    });

} catch (MomentException | ClockException $e) {
    echo $e->getMessage();
}