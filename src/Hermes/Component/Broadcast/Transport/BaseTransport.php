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

namespace Hermes\Component\Broadcast\Transport;

use Hermes\Component\Broadcast\Message\MessageInterface;
use Hermes\Component\Broadcast\Message\RawMessageInterface;
use Hermes\Component\Broadcast\Provider\ProviderInterface;
use Hermes\Component\Broadcast\Subscription\SubscriptionInterface;

abstract class BaseTransport implements TransportInterface
{
    /**
     * @var ProviderInterface[]
     */
    protected $providers = [];

    protected $messages = [];

    /**
     * @param SubscriptionInterface $subscriptions
     * @param MessageInterface $message
     */
    public function queue(SubscriptionInterface $subscriptions, MessageInterface $message)
    {
        $address = $subscriptions->getAddress();
        $rawMessage = $this->adaptMessage($message);
        if ($rawMessage) {
            $this->messages[] = [$address, $rawMessage, md5(json_encode($rawMessage))];
        }
    }

    public function flush($compact = false)
    {
        $compactedMessages = $this->compactMessages();
        array_map(function ($message) {
            $this->getProvider()->send($message['message'], $message['address']);
         }, $compactedMessages);

    }

    /**
     * @param $message
     *
     * @return RawMessageInterface
     */
    public function adaptMessage(MessageInterface $message)
    {
        //todo: if there us not specific message use translator
        return $message->getMessageByTransport(self::class);
    }

    /**
     * @param ProviderInterface $provider
     */
    public function addProvider(ProviderInterface $provider)
    {
        if ($provider->getTransportClass() === self::class) {
            $this->providers[] = $provider;
        }
    }

    /**
     * @return array
     */
    private function compactMessages()
    {
        $compactedMessages = [];
        foreach ($this->messages as $message) {
            if (!is_array($compactedMessages[$message[2]])) {
                $compactedMessages[$message[2]] = [];
                $compactedMessages[$message[2]]['message'] = [$message];
                $compactedMessages[$message[2]]['addresses'] = [];
            }
            $compactedMessages[$message[2]]['addresses'][] = $message[1];
        }
        return $compactedMessages;
    }


    private function getProvider()
    {
        //Implement an algorithm return function
        return $this->providers[0];
    }
}
