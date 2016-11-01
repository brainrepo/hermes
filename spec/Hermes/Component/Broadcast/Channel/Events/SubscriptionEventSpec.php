<?php

namespace spec\Hermes\Component\Broadcast\Channel\Events;

use Hermes\Component\Broadcast\Channel\Events\SubscriptionEvent;
use Hermes\Component\Broadcast\Channel\SubscriptionInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SubscriptionEventSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SubscriptionEvent::class);
    }

    function let(SubscriptionInterface $subscription)
    {
        $this->beConstructedWith($subscription);
    }
}
