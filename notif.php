<?php

include __DIR__.'/vendor/autoload.php';

use Joli\JoliNotif\Notification;
use Joli\JoliNotif\NotifierFactory;

// Create a Notifier
$notifier = NotifierFactory::create();

// Create your notification
$notification =
    (new Notification())
        ->setTitle('Notification title')
        ->setBody('This is the body of your notification')
        ->setIcon(__DIR__.'/path/to/your/icon.png')
        ->addOption('subtitle', 'This is a subtitle') // Only works on macOS (AppleScriptNotifier)
        ->addOption('sound', 'Frog') // Only works on macOS (AppleScriptNotifier)
;

// Send it
$notifier->send($notification);