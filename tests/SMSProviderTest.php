<?php

namespace Tests;

use Parsilver\SMS\Contract\SMSProvider;
use Parsilver\SMS\Facade\SMS;
use Parsilver\SMS\Provider\FakeSMSProvider;
use Parsilver\SMS\Provider\NullSMSProvider;
use Parsilver\SMS\Provider\SmartcommSMSProvider;
use Parsilver\SMS\SMSServiceProvider;

class SMSProviderTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->register(SMSServiceProvider::class);
    }

    public function testShouldBeNullProviderByDefault()
    {
        $this->assertInstanceOf(
            NullSMSProvider::class, $this->app->make(SMSProvider::class)
        );
    }


    public function testSpecifyDriver()
    {
        // Current driver should be null
        $this->assertInstanceOf(
            NullSMSProvider::class, SMS::driver()
        );

        // Try to specify smartcomm driver
        $this->assertInstanceOf(
            SmartcommSMSProvider::class, SMS::driver('smartcomm')
        );

        // Driver shouldn't change
        $this->assertInstanceOf(
            NullSMSProvider::class, $this->app->make(SMSProvider::class)
        );
        $this->assertInstanceOf(
            NullSMSProvider::class, SMS::driver()
        );
    }


    public function testShouldBeFakeProviderWhenSwapToFake()
    {
        SMS::fake();

        $this->assertInstanceOf(
            FakeSMSProvider::class, $this->app->make(SMSProvider::class)
        );
    }


    public function testSendSuccess()
    {
        SMS::fake();

        SMS::send(
            $phoneNumber = '0899999999',
            $message = 'This is message'
        );

        SMS::assertSent($phoneNumber, $message);
    }


    protected function getPackageProviders($app)
    {
        return [
            SMSServiceProvider::class,
        ];
    }


    protected function getPackageAliases($app)
    {
        return [
            'SMS' => SMS::class,
        ];
    }
}