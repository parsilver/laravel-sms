<?php namespace Parsilver\SMS\Facade;

use Illuminate\Support\Facades\Facade;
use Parsilver\SMS\Contract\SMSProvider;
use Parsilver\SMS\Provider\FakeSMSProvider;

/**
 * @method static void send(string $phoneNumber, string $message)
 * @method static void assertSent(string $phoneNumber, string|null $expectMessage = null)
 *
 * Class SMS
 * @package Parsilver\SMS\Facade
 */
class SMS extends Facade
{
    /**
     * For test
     */
    public static function fake()
    {
        static::swap(new FakeSMSProvider());
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return SMSProvider::class;
    }
}