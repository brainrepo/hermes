<?php

namespace spec\Hermes\Component\Broadcast\Channel\Events;

use Hermes\Component\Broadcast\Channel\Events\SubscriptionStartedEvent;
use Hermes\Component\Broadcast\Channel\Subscription;
use Hermes\Component\Broadcast\Channel\SubscriptionInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SubscriptionStartedEventSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SubscriptionStartedEvent::class);
    }

    function let(SubscriptionInterface $subscription)
    {
        $this->beConstructedWith($subscription);
    }
}
