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

use Hermes\Component\Broadcast\Exception\ProviderNotCompatibleException;
use Hermes\Component\Broadcast\Message\MessageInterface;
use Hermes\Component\Broadcast\Provider\ProviderInterface;
use Hermes\Component\Broadcast\Subscription\SubscriptionInterface;

abstract class BaseTransport implements TransportInterface
{
    /**
     * @var ProviderInterface[]
     */
    protected $providers = [];

    /**
     * @var array[]
     */
    protected $messages = [];

    /**
     * BaseTransport constructor.
     *
     * @param \Hermes\Component\Broadcast\Provider\ProviderInterface[] $providers
     */
    public function __construct(array $providers)
    {
        $this->providers = $providers;
    }

    /**
     * @param SubscriptionInterface $subscription
     * @param MessageInterface      $message
     */
    public function queue(SubscriptionInterface $subscription, MessageInterface $message)
    {
        $address = $subscription->getAddress();
        $rawMessage = $this->adaptMessage($message);
        if ($rawMessage) {
            $this->messages[] = [$address, $rawMessage, md5(json_encode($rawMessage))];
        }
    }

    /**
     * @param int $attempts
     */
    public function flush($attempts = 3)
    {
        $compactedMessages = $this->compactMessages();
        array_map(function ($message) use ($attempts) {
            $this->getProvider()->send($message['message'], $message['addresses'], $attempts);
        }, $compactedMessages);
    }

    /**
     * @param ProviderInterface $provider
     *
     * @throws ProviderNotCompatibleException
     */
    public function addProvider(ProviderInterface $provider)
    {
        if (!($provider->getTransportClass() === self::class)) {
            throw new ProviderNotCompatibleException(sprintf('You are trying to add a provider which support %s transport to a %s.', $provider->getTransportClass(), self::class));
        }
        $this->providers[] = $provider;
    }

    /**
     * @return array
     */
    private function compactMessages()
    {
        $compactedMessages = [];
        foreach ($this->messages as $message) {
            if (!key_exists($message[2], $compactedMessages) || (!is_array($compactedMessages[$message[2]]))) {
                $compactedMessages[$message[2]] = [];
                $compactedMessages[$message[2]]['message'] = $message[1];
                $compactedMessages[$message[2]]['addresses'] = [];
            }
            $compactedMessages[$message[2]]['addresses'][] = $message[0];
        }

        return $compactedMessages;
    }

    /**
     * @return ProviderInterface
     */
    private function getProvider()
    {
        //Implement an algorithm return function
        return $this->providers[0];
    }
}
