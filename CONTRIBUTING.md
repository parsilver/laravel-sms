# Contributing

หากท่านต้องการมีส่วนร่วมพัฒนาต่อใน repository นี้ ท่านต้องดำเนินการตามคำแนะนำด้านล่าง


## ขั้นตอนการเพิ่มผู้ให้บริการ SMS
1). สร้างผู้ให้บริการ Class ใหม่
```php
<?php namespace Parsilver\SMS\Provider;

// Location -> src/Provider/ExampleSMSProvider.php
class ExampleSMSProvider extends AbstractSMSProvider
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


2). เพิ่ม provider ใน src/config.php
```php
<?php

return [

    'default' => env('SMS_PROVIDER', null),

    'providers' => [
        // ...
        
        // Your provider config here
        'example' => [
            //
        ]
    ]
];
```

3). เพิ่ม method ให้ src/Manager.php
```php
<?php namespace Parsilver\SMS;

use Illuminate\Support\Manager as BaseManager;
use Parsilver\SMS\Provider\ExampleSMSProvider;

class Manager extends BaseManager
{
    // ....
    
    /**
     * @return ExampleSMSProvider
     */
    protected function createExampleDriver()
    {
        return new ExampleSMSProvider();
    }
    
    // ....
}
```



## การ Pull Request

1. ต้องให้แน่ใจก่อนว่าท่านจะไม่ลบ dependency ของทางเรากำหนดมา
2. ท่านต้องอัพเดดการเปลี่ยนแปลงผ่าน [README.md](README.md) ด้วย เพื่อแจ้งให้ผู้ใช้งานรับทราบ