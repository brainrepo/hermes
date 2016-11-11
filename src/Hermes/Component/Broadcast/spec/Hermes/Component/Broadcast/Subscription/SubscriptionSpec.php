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

use Hermes\Component\Broadcast\Receiver\AddressInterface;
use Hermes\Component\Broadcast\Subscription\Subscription;
use Hermes\Component\Broadcast\Transport\TransportInterface;
use PhpSpec\ObjectBehavior;

class SubscriptionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Subscription::class);
    }

    public function let(AddressInterface $address)
    {
        $this->beConstructedWith($address, TransportInterface::class, 'brainrepo_football_friends', 5);
    }

    public function it_can_get_address(AddressInterface $address)
    {
        $this->getAddress()->shouldReturn($address);
    }

    public function it_can_return_transport_class()
    {
        $this->getTransportClass()->shouldReturn(TransportInterface::class);
    }

    public function it_can_return_channel_id()
    {
        $this->getChannelId()->shouldReturn('brainrepo_football_friends');
    }

    public function it_can_be_not_elapsed()
    {
        $this->isActive()->shouldReturn(true);
    }
}
