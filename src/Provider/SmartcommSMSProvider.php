<?php namespace Parsilver\SMS\Provider;

use Parsilver\SMS\Contract\SMSProvider;

class SmartcommSMSProvider implements SMSProvider
{
    const URL = 'http://smartcomm2.net/sc2lc/SendMessage';

    public $username;
    public $password;
    public $options;

    /**
     * Smartcomm2SMSProvider constructor.
     * @param string $username
     * @param string $password
     * @param array $options
     */
    public function __construct($username, $password, $options = [])
    {
        $this->username = $username;
        $this->password = $password;
        $this->options = $options;
    }

    /**
     * @param string $phoneNumber
     * @param string $message
     * @return string|null
     */
    public function send($phoneNumber, $message)
    {
        $sender = isset($this->options['sender']) ? $this->options['sender'] : null;

        $payload = [
            'ACCOUNT' => $this->username,
            'PASSWORD' => $this->password,
            'MESSAGE'  => $this->utf8ToTis620($message),
            'MOBILE'   => $phoneNumber
        ];

        if(! is_null($sender)) {
            $payload['sender'] = $sender;
        }

        $response = (new Client)->post(static::URL, [
            'form_params' => $payload
        ]);

        // If success
        if($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
            return (string)$response->getBody();
        }

        return null;
    }


    /**
     * @param $message
     * @return string
     */
    private function utf8ToTis620($message) {
        $result = "";

        for ($index = 0; $index < strlen($message); $index++) {

            if (ord($message[$index]) == 224) {
                $unicode = ord($message[$index + 2]) & 0x3F;
                $unicode |= (ord($message[$index + 1]) & 0x3F) << 6;
                $unicode |= (ord($message[$index]) & 0x0F) << 12;
                $result .= chr($unicode - 0x0E00 + 0xA0);
                $index += 2;
            } else {
                $result .= $message[$index];
            }
        }

        return $result;
    }
}