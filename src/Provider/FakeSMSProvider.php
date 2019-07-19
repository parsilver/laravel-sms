<?php namespace Parsilver\SMS\Provider;

use PHPUnit\Framework\Assert as PHPUnit;

class FakeSMSProvider extends AbstractSMSProvider
{
    /**
     * All of the messages that have been sent.
     *
     * @var array
     */
    private $messages = [];

    /**
     * Assert if a message was sent
     *
     * @param $phoneNumber
     * @param string|null $expectMessage
     * @return void
     */
    public function assertSent($phoneNumber, $expectMessage = null)
    {
        $message = "The expected [{$phoneNumber}] SMS was not sent.";

        PHPUnit::assertTrue(
            $this->hasSent($phoneNumber, $expectMessage), $message
        );
    }

    /**
     * @param $phoneNumber
     * @param string|null $expectMessage
     * @return bool
     */
    public function hasSent($phoneNumber, $expectMessage = null)
    {
        $sent = isset($this->messages[$phoneNumber]);

        if($sent && ! is_null($expectMessage)) {
            foreach ($this->messages[$phoneNumber] as $message) {
                if($expectMessage === $message) {
                    return true;
                }
            }
        }

        return $sent;
    }

    /**
     * @param string $phoneNumber
     * @param string $message
     */
    public function send($phoneNumber, $message)
    {
        $this->messages[$phoneNumber][] = $message;
    }
}