<?php namespace Parsilver\SMS\Contract;

interface SMSProvider extends SMSProviderFactory
{
    /**
     * @param string $phoneNumber
     * @param string $message
     */
    public function send($phoneNumber, $message);
}