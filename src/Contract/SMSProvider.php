<?php namespace Parsilver\SMS\Contract;

interface SMSProvider
{
    /**
     * @param string $phoneNumber
     * @param string $message
     */
    public function send($phoneNumber, $message);
}