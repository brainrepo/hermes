<?php

namespace spec\Hermes\Component\Broadcast\Channel\Events;

use Hermes\Component\Broadcast\Channel\Events\SubscriptionEndedEvent;
use Hermes\Component\Broadcast\Channel\SubscriptionInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SubscriptionEndedEventSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SubscriptionEndedEvent::class);
    }

    function let(SubscriptionInterface $subscription)
    {
        $this->beConstructedWith($subscription);
    }
}
