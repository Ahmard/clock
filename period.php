<?php

use League\Period\Datepoint;

require 'vendor/autoload.php';

$diff = Datepoint::create('1 minutes 45 seconds');
dump($diff->getTimestamp());

$moment = new \Moment\Moment('1 hours 45 minutes 5 seconds');
$moment = $moment->fromNow();
dump(abs($moment->getMinutes()));
