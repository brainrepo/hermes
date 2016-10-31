<?php

namespace spec\Hermes\Component\Broadcast\Channel;

use Hermes\Component\Broadcast\Channel\SubscriptionInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ChannelSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Hermes\Component\Broadcast\Channel\Channel');
    }

    function let()
    {
        $this->beConstructedWith('soccer_team_group');
    }

    function it_can_get_name()
    {
        $this->getName()->shouldReturn('soccer_team_group');
    }

    function it_can_add_subscription(SubscriptionInterface $subscription)
    {
        $this->addSubscription($subscription);
    }
}
