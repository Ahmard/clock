<?php

use React\ChildProcess\Process;

require 'vendor/autoload.php';

\Clock\Clock::setLoop(\React\EventLoop\Factory::create());

\Clock\Sound::playReminder2();