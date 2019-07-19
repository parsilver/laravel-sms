# Laravel SMS

ส่ง SMS ไม่ใช่เรื่องยากอีกต่อไป เพียงแค่
```php
<?php

\SMS::send('0899991111', 'This is message');
```

### ความต้องการระบบ

```
PHP 7.1 ขึ้นไป
Laravel 5.x ขึ้นไป
```

### ติดตั้ง

ติดตั้งด้วยคำสั่ง composer

```
composer require parsilver/laravel-sms
```

หรือ เพิ่ม dependency เข้าไปใน composer

```
{
  "require": {
    "parsilver/laravel-sms": "^1.0"
  },
}
```


แล้วรันคำสั่ง
```
php artisan vendor:publish --provider="Parsilver\SMS\SMSServiceProvider" --tag="config"
```
คุณก็จะได้คอนฟิกไฟล์ที่
```
/config/sms.php
```

## ผู้ให้บริการ SMS
ตอนนี้ทางเรามีแค่ของ smartcomm เท่านั้นนะครับ หากท่านใดสนใจเพิ่มผู้ให้บริการก็ pull request มาได้เลยนะครับ

#### Smartcomm Provider
ดูเพิ่มเติมที่ [Net-Innova](http://www.net-innova.com/net_sms_marketing.html)

โปรดติดตั้ง guzzlehttp ก่อนการใช้งาน
```
composer require guzzlehttp/guzzle
```
```dotenv
# .env
SMS_PROVIDER=smartcomm
SMS_SMARTCOMM_USERNAME=xxxxxx
SMS_SMARTCOMM_PASSWORD=xxxxxx
```

#### Null Provider
ไม่ทำการส่งใดๆทั้งสิ้น
```dotenv
# .env
SMS_PROVIDER=null
```

## การใช้งานเบื้องต้น
คุณสามารถส่งข้อความผ่านคำสั่งสั้นๆได้ด้วย SMS class
```php
<?php

\SMS::send('0899991111', 'This is message');
```

หรือด้วยวิธีจากการทำ DI ซึ่งในตัวอย่างนี้ทางเราได้ทำใน Controller ครับ ซึ่งท่านจะต้อง import class ด้านล่างเพื่อใช้งานด้วยครับ
```php
<?php
use Parsilver\SMS\Contract\SMSProvider;
```
```php
<?php

use App\Http\Controllers\Controller;
use Parsilver\SMS\Contract\SMSProvider;

class UserController extends Controller
{
    /**
    * @var SMSProvider 
     */
    private $sms;
    
    public function __construct(SMSProvider $sms) 
    {
        $this->sms = $sms;
    }
    
    public function handle()
    {
        //...
        $this->sms->send('0999999999', 'This is message');
        //...
    }
}
```


## สร้างผู้ให้บริการของตัวเอง
ในบางครั้งท่านอาจจะมีผู้ให้บริการของท่านเองอยู่แล้ว แต่อยากจะ Customize เอง สามารถทำได้ดังนี้
```php
<?php App\SMS;

use Parsilver\SMS\Provider\AbstractSMSProvider;

class MyProvider extends AbstractSMSProvider
{
    /**
     * @param string $phoneNumber
     * @param string $message
     */
    public function send($phoneNumber, $message)
    {
        // Process your provider here...
    }
}
```

จากนั้นให้ไปลงทะเบียนที่ app\Providers\AppServiceProvider.php
```php
<?php namespace App\Providers;

use Parsilver\SMS\Facade\SMS;

class AppServiceProvider extends ServiceProvider
{
    //....
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        SMS::extend('myProvider', function() {
            return new MyProvider();
        });
    }
}
```

และเรียกใช้งานได้ด้วย
```php
\SMS::driver('myProvider')->send('0999999999', 'This is message');
```


## การทดสอบใน PHPUnit
คุณสามารถเปลี่ยนผู้ให้บริการเพื่อทดสอบได้ด้วย


```php
<?php 
use Parsilver\SMS\Facade\SMS;

SMS::fake();
```

ยกตำอย่างเช่น
```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use Parsilver\SMS\Facade\SMS;

class ExampleTest extends TestCase
{
    
    public function testShouldSuccess()
    {
        // Set SMS Provider to Fake SMS
        SMS::fake();
        
        $phoneNumber = '0989999999';
        $message = 'This is message';
        
        // Try to send
        SMS::send($phoneNumber, $message);
        
        // Assert
        SMS::assertSent($phoneNumber, $message);
    }
}
```


# Contributing

หากท่านต้องการมีส่วนร่วมพัฒนาต่อใน repository นี้ ท่านต้องดำเนินการตามคำแนะนำดังนี้

อ่านเพิ่มเติมที่ [CONTRIBUTING.md](CONTRIBUTING.md)