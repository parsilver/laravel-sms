<?php namespace Parsilver\SMS;

use Illuminate\Support\Manager as BaseManager;
use Parsilver\SMS\Contract\SMSProviderFactory;
use Parsilver\SMS\Provider\NullSMSProvider;
use Parsilver\SMS\Provider\SmartcommSMSProvider;

class Manager extends BaseManager implements SMSProviderFactory
{
    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app['config']['sms.default'] ?: 'null';
    }

    /**
     * @return SmartcommSMSProvider
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function createSmartcommDriver()
    {
        $config = $this->app['config']['sms.providers.smartcomm'];

        return new SmartcommSMSProvider($config['username'], $config['password']);
    }

    /**
     * @return NullSMSProvider
     */
    protected function createNullDriver()
    {
        return new NullSMSProvider();
    }
}