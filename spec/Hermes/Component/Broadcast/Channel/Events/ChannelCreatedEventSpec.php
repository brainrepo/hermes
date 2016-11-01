<?php

namespace spec\Hermes\Component\Broadcast\Channel\Events;

use Hermes\Component\Broadcast\Channel\ChannelInterface;
use Hermes\Component\Broadcast\Channel\Events\ChannelCreatedEvent;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ChannelCreatedEventSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ChannelCreatedEvent::class);
    }

    function let(ChannelInterface $channel)
    {
        $this->beConstructedWith($channel);
    }
}
