<?php

include __DIR__ . '/vendor/autoload.php';

use Clock\Clock;
use Clock\Notification;

$notification = Notification::create()
    ->setTitle('My Title')
    ->setIcon('/drive/path/to/icon.jpg');

$notification
    ->setBody('My notification body here')
    ->send();

Clock::forEach('2 minutes', function () use ($notification){
    $notification->setBody('Two minutes has passed');
    $notification->send();
});
