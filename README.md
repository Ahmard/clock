# PHP Clock
A clock description here...

## Installation
```
composer require ahmard/clock
```

## Usage
- Seconds
```php
use Clock\Clock;

Clock::forEachSecond(function (){
    echo "1 second has passed\n";   
});

Clock::forEachSecond(5, function (){
    echo "5 seconds has passed\n";   
});
```
- Minutes
```php
use Clock\Clock;

Clock::forEachMinute(2, function (){
    echo "2 minutes has passed\n";   
});
```
- Hours
```php
use Clock\Clock;

Clock::forEachHour(1, function (){
    echo "1 hour has passed\n";   
});
```

### Advance usage

```php
use Clock\Clock;
use React\EventLoop\TimerInterface;

Clock::forEach('1 minute 5 seconds', function (){
    echo "1 minute 5 seconds has passed\n";   
});

Clock::forEach('2 minutes', function (TimerInterface $timer){
    echo "2 minutes has passed\n";   
    Clock::stop($timer);
});
```

### Sound
This library comes with sounds out of the box<br/>
To use them, you will need to install [Sox](http://sox.sourceforge.net/)

```php
use Clock\Clock;use Clock\Sound;

Sound::play(__DIR__ . '/test.mp3');

Clock::forEachMinute(function (){
    Sound::playAlarm();
});
```

### Notification
Push [notification](https://github.com/jolicode/JoliNotif) to your system

```php
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

```