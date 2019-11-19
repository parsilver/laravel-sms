<?php namespace Parsilver\SMS\Contract;

interface SMSProvider extends SMSProviderFactory
{
    /**
     * @param string $phoneNumber
     * @param string $message
     * @return mixed
     */
    public function send($phoneNumber, $message);
}