<?php namespace Parsilver\SMS\Provider;

use Parsilver\SMS\Contract\SMSProvider;
use Parsilver\SMS\Contract\SMSProviderFactory;

abstract class AbstractSMSProvider implements SMSProvider
{
    /**
     * @param null $driver
     * @return mixed|void
     */
    public function driver($driver = null)
    {
        return resolve(SMSProviderFactory::class)->driver($driver);
    }
}