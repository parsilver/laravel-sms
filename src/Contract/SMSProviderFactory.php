<?php namespace Parsilver\SMS\Contract;

interface SMSProviderFactory
{
    /**
     * Get a driver instance.
     *
     * @param  string  $driver
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public function driver($driver = null);
}