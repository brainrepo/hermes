<?php

namespace spec\Hermes\Component\Broadcast\Receiver;

use Hermes\Component\Broadcast\Receiver\AddressInterface;
use Hermes\Component\Broadcast\Receiver\Receiver;
use Hermes\Component\Broadcast\Transport\TransportInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ReceiverSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Receiver::class);
    }

    function let(AddressInterface $addressInterface)
    {
        $this->beConstructedWith(array(TransportInterface::class => $addressInterface ));
    }

    function it_can_get_addresses_by_transport(AddressInterface $addressInterface)
    {
        $this->getAddressByTransport(TransportInterface::class)->shouldReturn($addressInterface);
    }

    function it__can_get_null_addresses_by_transport()
    {
        $this->getAddressByTransport('wrong_class_name')->shouldReturn(null);

    }

}
