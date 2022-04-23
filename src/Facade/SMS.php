<?php namespace Parsilver\SMS\Facade;

use Closure;
use Illuminate\Support\Facades\Facade;
use Parsilver\SMS\Contract\SMSProvider;
use Parsilver\SMS\Contract\SMSProviderFactory;
use Parsilver\SMS\Provider\FakeSMSProvider;

/**
 * @method static void send(string $phoneNumber, string $message)
 * @method static \Parsilver\SMS\Contract\SMSProvider driver(string $driver = null)
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
    public static function fake($driver = null)
    {
        $driver = $driver ?: 'fake';

        static::extend($driver, function() {
            return new FakeSMSProvider();
        });

        static::swap(resolve(SMSProviderFactory::class)->driver($driver));
    }

    /**
     * @param string $driver
     * @param Closure $closure
     * @return SMSProviderFactory
     */
    public static function extend(string $driver, Closure $closure)
    {
        return resolve(SMSProviderFactory::class)->extend($driver, $closure);
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