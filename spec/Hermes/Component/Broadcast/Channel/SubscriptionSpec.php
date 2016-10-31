<?php

namespace spec\Hermes\Component\Broadcast\Channel;

use Hermes\Component\Broadcast\Transport\AddressInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SubscriptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Hermes\Component\Broadcast\Channel\Subscription');
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
