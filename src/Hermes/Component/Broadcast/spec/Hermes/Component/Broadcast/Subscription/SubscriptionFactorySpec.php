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

namespace spec\Hermes\Component\Broadcast\Subscription;

use Hermes\Component\Broadcast\Exception\AddressNotFoundException;
use Hermes\Component\Broadcast\Receiver\AddressInterface;
use Hermes\Component\Broadcast\Receiver\ReceiverInterface;
use Hermes\Component\Broadcast\Subscription\SubscriptionFactory;
use Hermes\Component\Broadcast\Transport\TransportInterface;
use PhpSpec\ObjectBehavior;

class SubscriptionFactorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(SubscriptionFactory::class);
    }

    public function it_can_create_subscription(ReceiverInterface $receiver, AddressInterface $address)
    {
        $receiver->getAddressByTransport(TransportInterface::class)->willReturn($address);
        $this->create($receiver, TransportInterface::class, 'brainrepo_football_friends', 2678400);
    }

    public function it_can_fail_creating_subscription(ReceiverInterface $receiver)
    {
        $this->shouldThrow(AddressNotFoundException::class)->duringCreate($receiver, TransportInterface::class, 'brainrepo_football_friends', 2678400);
    }
}
