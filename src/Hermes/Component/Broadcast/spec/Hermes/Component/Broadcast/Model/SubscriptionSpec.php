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

class SubscriptionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Subscription::class);
    }

    public function let(AddressInterface $address)
    {
        $this->beConstructedWith($address, 'transport');
    }

    public function it_can_get_address(AddressInterface $address)
    {
        $this->getAddress()->shouldReturn($address);
    }

    public function it_can_get_transport_id()
    {
        $this->getTransportId()->shouldReturn('transport');
    }
}
