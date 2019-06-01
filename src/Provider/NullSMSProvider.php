<?php namespace Parsilver\SMS\Provider;

use Parsilver\SMS\Contract\SMSProvider;

class NullSMSProvider implements SMSProvider
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