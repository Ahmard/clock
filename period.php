<?php

use League\Period\Datepoint;

require 'vendor/autoload.php';

$diff = Datepoint::create('1 minutes 45 seconds')->getTimestamp() - time();
dump($diff / 60);