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

namespace spec\Hermes\Component\Broadcast\Receiver;

use Hermes\Component\Broadcast\Receiver\AddressInterface;
use Hermes\Component\Broadcast\Receiver\Receiver;
use Hermes\Component\Broadcast\Transport\TransportInterface;
use PhpSpec\ObjectBehavior;

class ReceiverSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Receiver::class);
    }

    public function let(AddressInterface $addressInterface)
    {
        $this->beConstructedWith([TransportInterface::class => $addressInterface]);
    }

    public function it_can_get_addresses_by_transport(AddressInterface $addressInterface)
    {
        $this->getAddressByTransport(TransportInterface::class)->shouldReturn($addressInterface);
    }

    public function it__can_get_null_addresses_by_transport()
    {
        $this->getAddressByTransport('wrong_class_name')->shouldReturn(null);
    }
}
