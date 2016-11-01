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

namespace spec\Hermes\Component\Broadcast\Model;

use Hermes\Component\Broadcast\Model\AddressInterface;
use Hermes\Component\Broadcast\Model\Subscription;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SubscriptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Subscription::Class);
    }

    function let(AddressInterface $address)
    {
        $this->beConstructedWith($address, 'transport');
    }

    function it_can_get_address(AddressInterface $address)
    {
        $this->getAddress()->shouldReturn($address);
    }

    function it_can_get_transport_id()
    {
        $this->getTransportId()->shouldReturn('transport');
    }
}
