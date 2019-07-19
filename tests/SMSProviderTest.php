<?php


use Parsilver\SMS\Contract\SMSProvider;
use Parsilver\SMS\Facade\SMS;
use Parsilver\SMS\Provider\NullSMSProvider;
use Parsilver\SMS\Provider\SmartcommSMSProvider;

class SMSProviderTest extends Orchestra\Testbench\TestCase
{

    public function testShouldBeNullProviderByDefault()
    {
        $this->assertInstanceOf(
            Parsilver\SMS\Provider\NullSMSProvider::class,
            $this->app->make(Parsilver\SMS\Contract\SMSProvider::class)
        );
    }


    public function testSpecifyDriver()
    {
        // Current driver should be null
        $this->assertInstanceOf(
            Parsilver\SMS\Provider\NullSMSProvider::class,
            Parsilver\SMS\Facade\SMS::driver()
        );

        // Try specify to smartcomm driver
        $this->assertInstanceOf(
            Parsilver\SMS\Provider\SmartcommSMSProvider::class,
            Parsilver\SMS\Facade\SMS::driver('smartcomm')
        );

        // Driver should't change
        $this->assertInstanceOf(
            Parsilver\SMS\Provider\NullSMSProvider::class,
            $this->app->make(Parsilver\SMS\Contract\SMSProvider::class)
        );
        $this->assertInstanceOf(
            Parsilver\SMS\Provider\NullSMSProvider::class,
            Parsilver\SMS\Facade\SMS::driver()
        );
    }


    public function testShouldBeFakeProviderWhenSwapToFake()
    {
        Parsilver\SMS\Facade\SMS::fake();

        $this->assertInstanceOf(
            Parsilver\SMS\Provider\FakeSMSProvider::class,
            $this->app->make(Parsilver\SMS\Contract\SMSProvider::class)
        );
    }


    public function testSendSuccess()
    {
        Parsilver\SMS\Facade\SMS::fake();

        Parsilver\SMS\Facade\SMS::send(
            $phoneNumber = '0899999999',
            $message = 'This is message'
        );

        Parsilver\SMS\Facade\SMS::assertSent($phoneNumber, $message);
    }


    protected function getPackageProviders($app)
    {
        return [
            Parsilver\SMS\SMSServiceProvider::class,
        ];
    }


    protected function getPackageAliases($app)
    {
        return [
            'SMS' => Parsilver\SMS\Facade\SMS::class,
        ];
    }
}