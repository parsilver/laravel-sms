<?php namespace Parsilver\SMS\Provider;

class NullSMSProvider extends AbstractSMSProvider
{
    /**
     * @param string $phoneNumber
     * @param string $message
     */
    public function send($phoneNumber, $message)
    {
        // TODO: Implement send() method.
    }
}