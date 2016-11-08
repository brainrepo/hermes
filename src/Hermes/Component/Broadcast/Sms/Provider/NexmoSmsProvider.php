<?php

/*
 * This file is part of the Hermes package.
 *
 * Copyright (c) 2014-2016 Mauro Murru Brainrepo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Mauro Murru Brainrepo <murru7@gmail.com>
 */

namespace Hermes\Component\Broadcast\Sms\Provider;

use Hermes\Component\Broadcast\Message\RawMessageInterface;
use Hermes\Component\Broadcast\Provider\ProviderInterface;
use Hermes\Component\Broadcast\Receiver\AddressInterface;
use Hermes\Component\Broadcast\Sms\SmsTransport;

class NexmoSmsProvider implements ProviderInterface
{
    const NEXMO_REST_URL = 'https://rest.nexmo.com/sms/json?';

    /**
     * @var string
     */
    private $apiKey;
    /**
     * @var string
     */
    private $apiSecret;
    /**
     * @var string
     */
    private $from;

    /**
     * NexmoSmsProvider constructor.
     *
     * @param string $apiKey
     * @param string $apiSecret
     * @param string $from
     */
    public function __construct($apiKey, $apiSecret, $from)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->from = $from;
    }

    public function getTransportClass()
    {
        return SmsTransport::class;
    }

    /**
     * @param RawMessageInterface $message
     * @param AddressInterface[] $addresses
     * @param int $attempts
     */
    public function send(RawMessageInterface $message, $addresses, $attempts = 3)
    {
        for ($i = 0; $i < $attempts; ++$i) {
            foreach ($addresses as $address) {
                $this->sendDataToServer($message, $address);
            }
        }
    }

    /**
     * @param RawMessageInterface $message
     * @param $address
     */
    private function sendDataToServer(RawMessageInterface $message, $address)
    {
        $url = $this::NEXMO_REST_URL . http_build_query(
                [
                    'api_key' => $this->apiKey,
                    'api_secret' => $this->apiSecret,
                    'to' => $address->getMobilePhoneNumber(),
                    'from' => $this->from,
                    'text' => $message->getText(),
                ]
            );
        try {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = json_decode(curl_exec($ch));
            if ($response != null && $response->messages[0]->status == 0) {
                unset($address);
            }
        } catch (\Exception $e) {
        }
    }
}
