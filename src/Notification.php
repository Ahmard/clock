<?php


namespace Clock;


use Joli\JoliNotif\Notifier;
use Joli\JoliNotif\NotifierFactory;

class Notification extends \Joli\JoliNotif\Notification
{
    protected Notifier $notifierFactory;

    public function __construct()
    {
        $this->notifierFactory = NotifierFactory::create();
    }

    public static function create(): Notification
    {
        return new Notification();
    }

    public function send(): void
    {
        $this->notifierFactory->send($this);
    }
}