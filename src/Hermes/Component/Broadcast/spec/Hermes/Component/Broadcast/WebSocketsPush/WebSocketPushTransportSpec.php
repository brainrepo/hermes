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

namespace spec\Hermes\Component\Broadcast\WebSocketsPush;

use Hermes\Component\Broadcast\Exception\ProviderNotCompatibleException;
use Hermes\Component\Broadcast\Message\MessageInterface;
use Hermes\Component\Broadcast\Message\RawMessageInterface;
use Hermes\Component\Broadcast\Provider\ProviderInterface;
use Hermes\Component\Broadcast\Receiver\AddressInterface;
use Hermes\Component\Broadcast\Subscription\SubscriptionInterface;
use Hermes\Component\Broadcast\WebSocketsPush\WebSocketPushTransport;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class WebSocketPushTransportSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(WebSocketPushTransport::class);
    }

    public function let(ProviderInterface $provider)
    {
        $this->beConstructedWith([$provider]);
    }

    public function it_can_queue_message(
        SubscriptionInterface $subscription,
        AddressInterface $address,
        MessageInterface $message,
        RawMessageInterface $rawMessage
    ) {
        $message->getMessageByTransport(WebSocketPushTransport::class)->willReturn($rawMessage); //??
        $subscription->getAddress()->willReturn($address);

        $this->queue($subscription, $message);
    }

    public function it_can_queue_adapted_message(SubscriptionInterface $subscription, AddressInterface $address, MessageInterface $message)
    {
        $message->getText()->willReturn('text');
        $message->getMessageByTransport(WebSocketPushTransport::class)->willReturn(null);
        $subscription->getAddress()->willReturn($address);

        $this->queue($subscription, $message);
    }

    public function it_can_add_provider(ProviderInterface $provider1)
    {
        $provider1->getTransportClass()->willReturn(WebSocketPushTransport::class);
        $this->addProvider($provider1->getWrappedObject());
    }

    public function it_can_throw_exception_if_provider_is_not_compatible(ProviderInterface $provider)
    {
        $provider->getTransportClass()->willReturn(self::class);
        $this->shouldThrow(ProviderNotCompatibleException::class)->duringAddProvider($provider);
    }

    public function it_can_flush(
        ProviderInterface $provider,
        SubscriptionInterface $subscription,
        RawMessageInterface $rawMessage,
        MessageInterface $message,
        AddressInterface $address)
    {
        $message->getMessageByTransport(Argument::any())->willReturn($rawMessage);
        $subscription->getAddress()->willReturn($address);
        $this->queue($subscription, $message);
        $this->flush(3);
        $provider->send($rawMessage, [$address], 3)->shouldBeCalled();
    }
}
