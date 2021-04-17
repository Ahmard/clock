<?php

use Clock\Clock;
use Clock\Sound;
use React\EventLoop\Factory;

require 'vendor/autoload.php';

Clock::setLoop(Factory::create());

Sound::play(__DIR__ . '/raw/alarm.wav');
