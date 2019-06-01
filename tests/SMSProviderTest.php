<?php


class SMSProviderTest extends Orchestra\Testbench\TestCase
{

    public function testShouldBeNullProviderByDefault()
    {
        $this->assertInstanceOf(
            Parsilver\SMS\Provider\NullSMSProvider::class,
            $this->app->make(Parsilver\SMS\Contract\SMSProvider::class)
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

        $phoneNumber = '0899999999';
        $message = 'This is message';

        Parsilver\SMS\Facade\SMS::send($phoneNumber, $message);

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